<?php

namespace Database\Seeders;

use App\Helpers\DataImport;
use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $path = DataImport::getStructureFilePath();
        $data = DataImport::parse($path);
        $data = $data['data'] ?? [];

        $structure = [];

        if (!empty($data)) {
            $structure = DataImport::buildStructure($data);
        }

        if (empty($structure)) {
            throw new \ArgumentCountError('Structure is empty');
        }

        foreach($structure as $category)
        {
            Category::create($category);
        }
    }
}
