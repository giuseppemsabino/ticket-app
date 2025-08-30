<?php

namespace Database\Seeders;

use App\Models\Ticket;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TicketsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       $tickets = [
            [
                'project_id' => 1,
                'area_id' => 1,
                'user_id' => 1,
                'assigned_to' => 1,
                'description' => 'Non riesco ad effettuare il login nella piattaforma.',
                'image' => null,
            ],
            [
                'project_id' => 1,
                'area_id' => 1,
                'user_id' => 1,
                'assigned_to' => 1,
                'description' => 'Quando tento di pagare ricevo un errore 500.',
                'image' => null,
            ],
            [
                'project_id' => 1,
                'area_id' => 1,
                'user_id' => 1,
                'assigned_to' => 1,
                'description' => 'La sezione dei prodotti appare vuota e non mostra nulla.',
                'image' => null,
            ],
        ];

        foreach ($tickets as $ticket){
            $newTicket = new Ticket();

            $newTicket->project_id = $ticket['project_id'];
            $newTicket->area_id = $ticket['area_id'];
            $newTicket->user_id = $ticket['user_id'];
            $newTicket->assigned_to = $ticket['assigned_to'];
            $newTicket->description = $ticket['description'];
            $newTicket->image = $ticket['image'];

            $newTicket->save();
        }
    }
}
