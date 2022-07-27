<?php

namespace Database\Seeders;

use App\Models\Forum;
use App\Models\ImageForum;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class ImageForumSeeder extends Seeder
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
            ImageForum::create([
                'forum_id' => Forum::all()->random()->id,
                'image_name' => $faker->name(),
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);
        }
    }
}
