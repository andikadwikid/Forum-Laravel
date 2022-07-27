<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\ImageAnswer;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ImageAnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 10; $i++) {
            ImageAnswer::create([
                'answer_id' => Answer::all()->random()->id,
                'image_name' => $faker->name(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
