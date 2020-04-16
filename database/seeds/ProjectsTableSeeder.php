<?php

use App\Models\Project;
use App\Models\User;
use Faker\Factory;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('fr_FR');

        for ($i=0; $i < 30; $i++) {
            Project::create([
                'name' => $faker->company,
                'admin_id' => 1,
                'customer_id' => mt_rand(2, 25),
                'status_id' => mt_rand(1, 4),
                'news' => $faker->sentence,
                'body' => $faker->paragraphs(mt_rand(2, 8), true),
            ]);
        }
    }
}
