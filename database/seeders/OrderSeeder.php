<?php

namespace Database\Seeders;

use App\Models\Order;
use Faker\Factory;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $data = [
            'email'       => $faker->email,
            'name'        => $faker->name,
            'tel'         => $faker->phoneNumber,
            'message'     => $faker->sentence,
            'status'      => 'new',
            'delivery_id' => 1,
        ];
        Order::create($data);
    }
}
