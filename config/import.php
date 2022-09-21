<?php

return [
    'root_path' => env('ROOT_PATH', dirname($_SERVER['DOCUMENT_ROOT'])),

    'import_directory' => realpath(base_path() . DIRECTORY_SEPARATOR .
        env('IMPORT_DIRECTORY', env('ROOT_PATH', dirname($_SERVER['DOCUMENT_ROOT'])) . '/resources/data')),

    'data_structure_directory' => env('DATA_STRUCTURE_DIRECTORY','structure'),

    'data_structure_file' => env('DATA_STRUCTURE_FILE','структура_фатом_конечная.xlsx'),

    'data_items_directory' => env('DATA_ITEMS_DIRECTORY','products'),

    'conformity_file' => env('CONFORMITY_FILE', 'conformity.json'),
];
