<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'name' => 'ecommerce',
                'description' => 'Gestione del negozio online',
            ],
            [
                'name' => 'gestionale_magazzino',
                'description' => 'Gestione del magazzino e inventario',
            ],
            [
                'name' => 'crm_clienti',
                'description' => 'Gestione dei clienti e contatti',
            ],
            [
                'name' => 'supporto_tecnico',
                'description' => 'Piattaforma di assistenza tecnica interna',
            ],
            [
                'name' => 'contabilita',
                'description' => 'Sistema di contabilità e fatturazione',
            ],
        ];

        foreach ($projects as $project){
            $newProject = new Project($project);

            $newProject->name = $project['name'];
            $newProject->description = $project['description'];

            $newProject->save();
        }
    }
}
