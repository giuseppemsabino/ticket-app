<?php

namespace Database\Seeders;

use App\Models\Ticket;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserTableSeeder::class,
            RolesTableSeeder::class,
            ProjectsTableSeeder::class,
            AreasTableSeeder::class,
            StatusesTableSeeder::class,
            TicketsTableSeeder::class,
            CommentsTableSeeder::class,
        ]);
    }
}
