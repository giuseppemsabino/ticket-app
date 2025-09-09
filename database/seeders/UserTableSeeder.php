<?php

namespace Database\Seeders;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        $now = Carbon::now();

        $users = [
            [
                'name' => 'Giuseppe Andres Mendoza Sabino',
                'email' => 'giuseppemendoza004@gmail.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password'), // password = "password"
            ],
            [
                'name' => 'mattia',
                'email' => 'mattia@gmail.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'chiara',
                'email' => 'chiara@gmail.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'manolo',
                'email' => 'manolo@gmail.com',
                'email_verified_at' => $now,
                'password' => Hash::make('password'),
            ],
            [
                'name' => 'Admin',
                'email' => 'admin@admin.com',
                'email_verified_at' => $now,
                'password' => Hash::make('admin123'), // password = "admin123"
            ],
        ];

        foreach ($users as $user) {
            $newUser = new User();

            $newUser->name = $user['name'];
            $newUser->email = $user['email'];
            $newUser->email_verified_at = $user['email_verified_at'];
            $newUser->password = $user['password'];

            $newUser->save();
        }
    }
}
