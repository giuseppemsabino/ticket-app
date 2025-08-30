<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = [
            [ 'name' => 'Utente',
              'description' => 'Utente standard del sistema'
            ],
            [ 'name' => 'Tecnico',
              'description' => 'Tecnico di supporto'
            ],
            [ 'name' => 'Admin',
              'description' => 'Amministratore del sistema'
            ],
            [ 'name' => 'SuperAdmin',
              'description' => 'Super amministratore con accesso completo'
            ]
        ];

        foreach($roles as $role){

            $newRole = new Role();

            $newRole->name = $role['name'];
            $newRole->description = $role['description'];

            $newRole->save();
        }
    }
}
