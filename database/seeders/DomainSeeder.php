<?php

namespace Database\Seeders;

use App\Models\Domains;
use Illuminate\Database\Seeder;

class DomainSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $cities = [
            'fatom.loc'            =>
                [
                    'city'    => 'Краснодар',
                    'address' => 'ул. Новороссийская,д. 236/1 лит. А, оф. 103',
                    'tel'     => '8 (861) 206-59-83',
                    'url'     => 'https://www.google.com/maps/search/?api=1&query=%D1%83%D0%BB.+%D0%9D%D0%BE%D0%B2%D0%BE%D1%80%D0%BE%D1%81%D1%81%D0%B8%D0%B9%D1%81%D0%BA%D0%B0%D1%8F,+236,+%D0%9A%D1%80%D0%B0%D1%81%D0%BD%D0%BE%D0%B4%D0%B0%D1%80,+%D0%9A%D1%80%D0%B0%D1%81%D0%BD%D0%BE%D0%B4%D0%B0%D1%80%D1%81%D0%BA%D0%B8%D0%B9+%D0%BA%D1%80%D0%B0%D0%B9,+%D0%A0%D0%BE%D1%81%D1%81%D0%B8%D1%8F,+350059'
                ],
            'stavropol.fatom.loc'  => [
                'city'    => 'Ставрополь',
                'address' => 'Старомарьевское ш. 32',
                'tel'     => '8 (865) 220-57-28',
                'url'     => 'https://www.google.com/maps/search/?api=1&query=%D0%A1%D1%82%D0%B0%D1%80%D0%BE%D0%BC%D0%B0%D1%80%D1%8C%D0%B5%D0%B2%D1%81%D0%BA%D0%BE%D0%B5+%D1%88.,+32,+%D0%A1%D1%82%D0%B0%D0%B2%D1%80%D0%BE%D0%BF%D0%BE%D0%BB%D1%8C,+%D0%A1%D1%82%D0%B0%D0%B2%D1%80%D0%BE%D0%BF%D0%BE%D0%BB%D1%8C%D1%81%D0%BA%D0%B8%D0%B9+%D0%BA%D1%80%D0%B0%D0%B9,+355008'
            ],
            'rnd.fatom.loc'        => [
                'city'    => 'Ростов-на-Дону',
                'address' => 'Малое Зеленое Кольцо д.3',
                'tel'     => '8 (861) 206-16-47',
                'url'     => 'https://www.google.com/maps/search/?api=1&query=%D1%83%D0%BB.+%D0%9C%D0%B0%D0%BB%D0%BE%D0%B5+%D0%97%D0%B5%D0%BB%D1%91%D0%BD%D0%BE%D0%B5+%D0%9A%D0%BE%D0%BB%D1%8C%D1%86%D0%BE,+3,+%D0%AF%D0%BD%D1%82%D0%B0%D1%80%D0%BD%D1%8B%D0%B9,+%D0%A0%D0%BE%D1%81%D1%82%D0%BE%D0%B2%D1%81%D0%BA%D0%B0%D1%8F+%D0%BE%D0%B1%D0%BB.,+344094'
            ],
            'simferopol.fatom.loc' => [
                'city'    => 'Симферополь',
                'address' => 'ул. Генерала Васильева д.27а',
                'tel'     => '8 (869) 277-71-18',
                'url'     => 'https://www.google.com/maps/search/?api=1&query=%D1%83%D0%BB.+%D0%93%D0%B5%D0%BD%D0%B5%D1%80%D0%B0%D0%BB%D0%B0+%D0%92%D0%B0%D1%81%D0%B8%D0%BB%D1%8C%D0%B5%D0%B2%D0%B0,+27,+%D0%A1%D0%B8%D0%BC%D1%84%D0%B5%D1%80%D0%BE%D0%BF%D0%BE%D0%BB%D1%8C'
            ],
            'sevastopol.fatom.loc' => [
                'city'    => 'Севастополь',
                'address' => 'Проспект Героев Сталинграда д.46А',
                'tel'     => '8 (869) 277-71-18',
                'url'     => 'https://www.google.com/maps/search/?api=1&query=%D0%BF%D1%80%D0%BE%D1%81%D0%BF.+%D0%93%D0%B5%D1%80%D0%BE%D0%B5%D0%B2+%D0%A1%D1%82%D0%B0%D0%BB%D0%B8%D0%BD%D0%B3%D1%80%D0%B0%D0%B4%D0%B0,+46,+%D0%A1%D0%B5%D0%B2%D0%B0%D1%81%D1%82%D0%BE%D0%BF%D0%BE%D0%BB%D1%8C'
            ],
            'sochi.fatom.loc'      => [
                'city'    => 'Сочи',
                'address' => 'ул. Пластуновская 52М',
                'tel'     => '8 (861) 206-59-83',
                'url'     => 'https://www.google.com/maps/search/?api=1&query=%D1%83%D0%BB.+%D0%9F%D0%BB%D0%B0%D1%81%D1%82%D1%83%D0%BD%D1%81%D0%BA%D0%B0%D1%8F,+52%D0%BC,+%D0%A1%D0%BE%D1%87%D0%B8,+%D0%9A%D1%80%D0%B0%D1%81%D0%BD%D0%BE%D0%B4%D0%B0%D1%80%D1%81%D0%BA%D0%B8%D0%B9+%D0%BA%D1%80%D0%B0%D0%B9,+354057'
            ]
        ];

        foreach ($cities as $domen => $data) {
            Domains::create([
                'domain'           => $domen,
                'domain_city'      => $data['city'],
                'domain_city_text' => $data['city'],
                'tel'              => $data['tel'],
                'tel2'             => $data['tel'],
                'address'          => $data['address'],
            ]);
        }
    }
}
