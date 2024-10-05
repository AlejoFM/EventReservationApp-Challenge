<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Juan Perez',
            'email' => 'juan@example.com',
            'password' => bcrypt('password123'),
            'role' => 'admin'
        ]);

        User::create([
            'name' => 'Manuel Gonzalez',
            'email' => 'manu@example.com',
            'password' => bcrypt('password123'),
            'role' => 'user'
        ]);
    }
}