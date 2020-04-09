<?php

use App\Models\StatusTicket;
use App\Models\InvoiceStatus;
use App\Models\StatusProject;
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
        // Status for project
        StatusProject::create(['name' => 'En développement']);
        StatusProject::create(['name' => 'En attente']);
        StatusProject::create(['name' => 'Terminé']);
        StatusProject::create(['name' => 'Abandonné']);

        // Status for ticket
        StatusTicket::create(['name' => 'En cours']);
        StatusTicket::create(['name' => 'Fermé']);
        StatusTicket::create(['name' => 'Ouvert']);
        StatusTicket::create(['name' => 'En attente']);
        StatusTicket::create(['name' => 'Résolu']);
        StatusTicket::create(['name' => 'Ré-ouvert']);

        //Status for invoices
        InvoiceStatus::create(['name' => 'Pending']);
        InvoiceStatus::create(['name' => 'Sent']);
        InvoiceStatus::create(['name' => 'Paid']);
        InvoiceStatus::create(['name' => 'Cancelled']);
    }
}
