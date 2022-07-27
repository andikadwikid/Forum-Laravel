<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $faker = Faker::create();

        // for ($i = 1; $i <= 10; $i++) {
        //     User::create([
        //         'firstname' => $faker->name(),
        //         'lastname' => $faker->name(),
        //         'username' => $faker->name(),
        //         'email' => $faker->email(),
        //         'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        //         'avatar' => $faker->name(),
        //         'provider_name' => $faker->randomElement(['google', 'email', 'github']),
        //         'provider_id' => $faker->numerify('#####################'),
        //         'created_at' => date('Y-m-d H:i:s'),
        //         'updated_at' => date('Y-m-d H:i:s'),
        //     ]);
        // }
    }
}
