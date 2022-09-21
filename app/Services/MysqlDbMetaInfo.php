<?php
namespace App\Services;

use Closure;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Support\Facades\DB;
use JetBrains\PhpStorm\ArrayShape;
use stdClass;

class MysqlDbMetaInfo
{
    /**
     * Change the database referred to by the connection (null is the default connection) to the provided character set
     * (e.g. utf8mb4) and collation (e.g. utf8mb4_unicode_ci). It may be necessary to change the length of some fixed
     * length columns such as char and varchar to work with the new encoding. In which case the new length of such
     * columns and a callback to determine whether or not that particular column should be altered may be provided. If a
     * connection other than the default connection is to be changed, the string referring to the connection may be
     * provided as the last parameter (This string will be passed to DB::connection(...) to retrieve an instance of that
     * connection).
     *
     * @param string $charset
     * @param string $collation
     * @param int|null $newColumnLength
     * @param Closure|null $columnLengthCallback
     * @param string|null $connection
     */
    public function changeDatabaseCharacterSetAndCollation(string $charset, string $collation, int $newColumnLength = null, Closure $columnLengthCallback = null, string $connection = null)
    {
        $tables = $this->getTables($connection);

        foreach ($tables as $table) {
            $this->updateColumnsInTable($table, $charset, $collation, $newColumnLength, $columnLengthCallback, $connection);
            $this->convertTableCharacterSetAndCollation($table, $charset, $collation, $connection);
        }

        $this->alterDatabaseCharacterSetAndCollation($charset, $collation, $connection);
    }

    /**
     * Get an instance of the database connection provided with an optional string referring to the connection. This
     * should be null if referring to the default connection.
     *
     * @param string|null $connection
     *
     * @return \Illuminate\Database\ConnectionInterface
     */
    public function getDatabaseConnection(string $connection = null): ConnectionInterface
    {
        return DB::connection($connection);
    }

    /**
     * Get a list of tables on the provided connection.
     *
     * @param null $connection
     *
     * @return array
     */
    public function getTables($connection = null): array
    {
        $tables = [];

        $results = $this->getDatabaseConnection($connection)->select('SHOW TABLES');
        foreach ($results as $result) {
            foreach ($result as $key => $value) {
                $tables[] = $value;
                break;
            }
        }

        return $tables;
    }

    /**
     * Given a stdClass representing the column, extract the required information in a more accessible format. The array
     * returned will contain the field name, the type of field (Without the length), the length where applicable (or
     * null), true/false indicating the column allowing null values and the default value.
     *
     * @param stdClass $column
     *
     * @return array
     */
    #[ArrayShape(['field' => "mixed", 'type' => "mixed", 'type_brackets' => "null|string", 'type_end' => "null|string", 'null' => "bool", 'default' => "mixed", 'charset' => "null|string", 'collation' => "string"])]
    public function extractInformationFromColumn(stdClass $column): array
    {
        $type = $column->Type;
        $typeBrackets = null;
        $typeEnd = null;

        if (preg_match('/^([a-z]+)(?:\\(([^\\)]+?)\\))?(.*)/i', $type, $matches)) {
            $type = strtolower(trim($matches[1]));

            if (isset($matches[2])) {
                $typeBrackets = trim($matches[2]);
            }

            if (isset($matches[3])) {
                $typeEnd = trim($matches[3]);
            }
        }

        return [
            'field' => $column->Field,
            'type' => $type,
            'type_brackets' => $typeBrackets,
            'type_end' => $typeEnd,
            'null' => strtolower($column->Null) == 'yes',
            'default' => $column->Default,
            'charset' => is_string($column->Collation) && ($pos = strpos($column->Collation, '_')) !== false ? substr($column->Collation, 0, $pos) : null,
            'collation' => $column->Collation
        ];
    }

    /**
     * Tell if the provided column is a string/character type and needs to have it charset/collation changed.
     *
     * @param array $column
     *
     * @return bool
     */
    public function isStringType(array $column): bool
    {
        return in_array(strtolower($column['type']), ['char', 'varchar', 'tinytext', 'text', 'mediumtext', 'longtext', 'enum', 'set']);
    }

    /**
     * Tell if the provided column is a string/character type with a length.
     *
     * @param array $column
     *
     * @return bool
     */
    public function isStringTypeWithLength(array $column): bool
    {
        return in_array(strtolower($column['type']), ['char', 'varchar']);
    }

    /**
     * Update all of the string/character columns in the database to be the new collation. Additionally, modify the
     * lengths of those columns that have them to be the newLength provided, when the shouldUpdateLength callback passed
     * returns true.
     *
     * @param string $table
     * @param string $charset
     * @param string $collation
     * @param int|null $newLength
     * @param Closure|null $shouldUpdateLength
     * @param string|null $connection
     */
    public function updateColumnsInTable(string $table, string $charset, string $collation, int $newLength = null, Closure $shouldUpdateLength = null, string $connection = null)
    {
        $columnsToChange = [];

        foreach ($this->getColumnsFromTable($table, $connection) as $column) {
            $column = $this->extractInformationFromColumn($column);

            if ($this->isStringType($column)) {
                $sql = "CHANGE '%field%' '%field%' %type%%brackets% CHARACTER SET %charset% COLLATE %collation% %null% %default%";
                $search = ['%field%', '%type%', '%brackets%', '%charset%', '%collation%', '%null%', '%default%'];
                $replace = [
                    $column['field'],
                    $column['type'],
                    $column['type_brackets'] ? '(' . $column['type_brackets'] . ')' : '',
                    $charset,
                    $collation,
                    $column['null'] ? 'NULL' : 'NOT NULL',
                    is_null($column['default']) ? ($column['null'] ? 'DEFAULT NULL' : '') : 'DEFAULT \'' . $column['default'] . '\''
                ];

                if ($this->isStringTypeWithLength($column) && $shouldUpdateLength($column) && is_int($newLength) && $newLength > 0) {
                    $replace[2] = '(' . $newLength . ')';
                }

                $columnsToChange[] = trim(str_replace($search, $replace, $sql));
            }
        }

        if (count($columnsToChange) > 0) {
            $query = "ALTER TABLE '{$table}' " . implode(', ', $columnsToChange);

            $this->getDatabaseConnection($connection)->update($query);
        }
    }

    /**
     * Get a list of all the columns for the provided table. Returns an array of stdClass objects.
     *
     * @param string $table
     * @param string|null $connection
     *
     * @return array
     */
    public function getColumnsFromTable(string $table, string $connection = null): array
    {
        return $this->getDatabaseConnection($connection)->select('SHOW FULL COLUMNS FROM ' . $table);
    }

    /**
     * Convert a table character set and collation.
     *
     * @param string $table
     * @param string $charset
     * @param string $collation
     * @param string|null $connection
     */
    public function convertTableCharacterSetAndCollation(string $table, string $charset, string $collation, string $connection = null)
    {
        $query = "ALTER TABLE {$table} CONVERT TO CHARACTER SET {$charset} COLLATE {$collation}";
        $this->getDatabaseConnection($connection)->update($query);

        $query = "ALTER TABLE {$table} DEFAULT CHARACTER SET {$charset} COLLATE {$collation}";
        $this->getDatabaseConnection($connection)->update($query);
    }

    /**
     * Change the entire database (The database represented by the connection) character set and collation.
     *
     * # Note: This must be done with the unprepared method, as PDO complains that the ALTER DATABASE command is not yet
     *         supported as a prepared statement.
     *
     * @param string $charset
     * @param string $collation
     * @param string|null $connection
     */
    public function alterDatabaseCharacterSetAndCollation(string $charset, string $collation, string $connection = null)
    {
        $database = $this->getDatabaseConnection($connection)->getDatabaseName();

        $query = "ALTER DATABASE {$database} CHARACTER SET {$charset} COLLATE {$collation}";

        $this->getDatabaseConnection($connection)->unprepared($query);
    }

    /**
     * Run the migrations.
     *
     * @return void
     * /
    /*public function up()
    {
        $this->changeDatabaseCharacterSetAndCollation('utf8mb4', 'utf8mb4_unicode_ci', 191, function ($column) {
            return $this->isStringTypeWithLength($column) && $column['type_brackets'] > 191;
        });
    }*/

    /**
     * Reverse the migrations.
     *
     * @return void
     * /
    /*public function down()
    {
        $this->changeDatabaseCharacterSetAndCollation('utf8', 'utf8_unicode_ci', 255, function ($column) {
            return $this->isStringTypeWithLength($column) && $column['type_brackets'] == 191;
        });
    }*/
}
