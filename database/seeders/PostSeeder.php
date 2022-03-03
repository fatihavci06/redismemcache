<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Post;
use Faker\Factory;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker=Factory::create();
        for($i=0;$i<1000;$i++){
            Post::create([
            'title'=>$faker->title,
            'body'=>$faker->text,
            'author'=>$faker->name
        ]);
        }
    }
}
