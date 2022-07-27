<?php

namespace Database\Seeders;

use App\Models\Forum;
use App\Models\Tag;
use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ForumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        for ($i = 1; $i <= 30; $i++) {
            Forum::create([
                'user_id' => User::all()->random()->id,
                'tags_id' => Tag::all()->random()->id,
                'slug' => $faker->name(),
                'forum_title' => $faker->name(),
                'forum_text' => $faker->sentence(),
                'answered' => $faker->boolean(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
