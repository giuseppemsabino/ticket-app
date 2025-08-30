<?php

namespace Database\Seeders;

use App\Models\Area;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AreasTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
            $areas = [
        'errore sito',
        'ordine errato',
        'cambio destinazione',
        'altro',
        'anagrafica',
        'schermata giacenze',
        'generica',
        ];

        foreach ($areas as $area) {
            $newArea = new Area();
            $newArea->name = $area;
            $newArea->save();
        }
    }
}