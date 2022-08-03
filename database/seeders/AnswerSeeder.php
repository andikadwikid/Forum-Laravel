<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Forum;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class AnswerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 20; $i++) {
            Answer::create([
                'forum_id' => Forum::all()->random()->id,
                'user_id' => User::all()->random()->id,
                'answer_content' => $faker->sentence(),
                'best_answer' => $faker->boolean(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
