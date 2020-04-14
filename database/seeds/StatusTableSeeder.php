<?php

use App\Models\Color;
use App\Models\Issue;
use App\Models\Priority;
use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Color::create(['name' => 'primary']);
        Color::create(['name' => 'danger']);
        Color::create(['name' => 'success']);
        Color::create(['name' => 'info']);
        Color::create(['name' => 'warning']);
        Color::create(['name' => 'secondary']);
        Color::create(['name' => 'dark']);
        Color::create(['name' => 'light']);

        Status::create(['name' => 'En cours', 'color_id' => 4]);
        Status::create(['name' => 'En attente', 'color_id' => 5]);
        Status::create(['name' => 'Terminé', 'color_id' => 3]);
        Status::create(['name' => 'Abandonné', 'color_id' => 2]);

        Issue::create(['name' => 'Bug']);
        Issue::create(['name' => 'Fonctionnalité']);
        Issue::create(['name' => 'Correction']);
        Issue::create(['name' => 'Avis']);
        Issue::create(['name' => 'Divers']);

        Priority::create(['name' => 'basse']);
        Priority::create(['name' => 'normal']);
        Priority::create(['name' => 'haute']);
        Priority::create(['name' => 'urgent']);
    }
}
