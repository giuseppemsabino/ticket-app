<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            'Aperto',        
            'In Lavorazione', 
            'Chiuso'         
        ];
        
        foreach ($statuses as $status){

            $newStatus = new Status();
            $newStatus->name = $status;
            $newStatus->save();
        }

    }
}
