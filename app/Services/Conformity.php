<?php
namespace App\Services;

use App\Models\Category;
use Illuminate\Support\Facades\DB;

class Conformity
{
    private array $doubles;

    private $conformityJson;

    /**
     * Auxiliary method that searches doubles in a categories by field $fieldName
     *
     * @param string $fieldName
     * @return array
     */
    private function findDoubles(string $idField = 'c_id', string $fieldName = 'transliterated_name'): array
    {
        if (empty($this->doubles)) {
            $sql = "
            SELECT c1.id as `" . $idField. "`, c1.`" . $fieldName . "` FROM categories c1 INNER JOIN categories c2 ON c1.name = c2.name AND c1.id != c2.id
                UNION
            SELECT c2.id as `" . $idField. "`, c2.`" . $fieldName . "` FROM categories c1 INNER JOIN categories c2 ON c1.name = c2.name AND c1.id != c2.id
            ";

            $this->doubles = DB::select($sql);
        }
        return $this->doubles;
    }

    public function getPrimaryCategoriesForProducts(): array
    {
        $doubles = $this->findDoubles();
        $primary = [];
        array_walk($doubles, function (&$item, $key) use ($doubles, &$primary) {
            $id = $item->c_id;
            foreach ($doubles as $double) {
                if ($double->c_id != $id && $double->transliterated_name == $item->transliterated_name) {
                    if (!isset($primary[$double->transliterated_name])) {
                        $primary[$double->transliterated_name] = $item->c_id > $double->c_id ? $double->c_id : $item->c_id;
                    }
                }
            }
        });
        return $primary;
    }

    protected function loadConformityConfiguration()
    {
        if (empty($this->conformityJson)) {
            $conformityFile = config('import.import_directory') . DIRECTORY_SEPARATOR . config('import.conformity_file');
            $this->conformityJson = json_decode(file_get_contents($conformityFile));
        }
    }

    public function findAlias(string $alias = '')
    {
        $this->loadConformityConfiguration();
        /**
         * @var Transliterator $transliterator
         */
        $transliterator = app()->get(Transliterator::class);
        $alias = $transliterator->transliterate($alias);
        if (!empty($this->conformityJson)) {
            $aliases = (array)$this->conformityJson->aliases;
            if (empty($alias)) {
                return $aliases;
            }
            foreach ($aliases as $fieldName => $_alias) {
                foreach ($_alias as $a) {
                    if ($a == $alias) {
                        return $fieldName;
                    }
                }
            }
        }
        return $alias;
    }

    public function getMainItemFieldsList()
    {
        $this->loadConformityConfiguration();
        if (!empty($this->conformityJson)) {
            return $this->conformityJson->mainItemFieldsList;
        }
    }

    public function getFields($headers): array
    {
        $fields = [];
        foreach ($headers as $header) {
            $fields[] = $this->findAlias($header);
        }
        return $fields;
    }

    public function findCategoryByName(string $transliteratedCategoryName): Category
    {
        return Category::where('transliterated_name', $transliteratedCategoryName)->get()->last();
    }
}
