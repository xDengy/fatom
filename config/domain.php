<?php

return [
    'env_stub'     => '.env',
    'storage_dirs' => [
        'app'       => [
            'public' => [
            ],
        ],
        'framework' => [
            'cache'    => [
            ],
            'testing'  => [
            ],
            'sessions' => [
            ],
            'views'    => [
            ],
        ],
        'logs'      => [
        ],
    ],
    'domains'      => [
        'fatom.loc'            => 'fatom.loc',
        'rnd.fatom.loc'        => 'rnd.fatom.loc',
        'sevastopol.fatom.loc' => 'sevastopol.fatom.loc',
        'simferopol.fatom.loc' => 'simferopol.fatom.loc',
        'sochi.fatom.loc'      => 'sochi.fatom.loc',
        'stavropol.fatom.loc'  => 'stavropol.fatom.loc',
    ],
    'replace'      => '[[!+cf.name_rp]]'
];
