<?php

namespace Database\Seeders;

use App\Helpers\DataImport;
use App\Services\Conformity;
use App\Services\DirectoryTraversal;
use App\Services\MysqlDbMetaInfo;
use App\Services\Transliterator;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(Conformity $conformity, Transliterator $transliterator, DirectoryTraversal $traversal, MysqlDbMetaInfo $dbMetaInfo)
    {
        $path = DataImport::getItemsDirectory();
        $files = $traversal->traverse($path);

        set_time_limit(0);
        ob_implicit_flush(true);
        $memoryLimiti = ini_get('memory_limit');
        ini_set('memory_limit','384M');

//        dd($files);
        foreach ($files as $file) {
            $filePath = DataImport::getItemsDirectory() . DIRECTORY_SEPARATOR . $file;
            if (DataImport::importProducts($filePath)) {
                echo $filePath . " successful imported\n";
            }
        }

        ini_set('memory_limit',$memoryLimiti);
    }
}
