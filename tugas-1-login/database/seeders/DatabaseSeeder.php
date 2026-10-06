<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'username' => 'Kevin',
            'password' => 'admin123',
            'nama_lengkap' => 'Kevin Akbar',
        ]);

        User::create([
            'username' => 'Salman',
            'password' => 'alfarisi123',
            'nama_lengkap' => 'Salman Alfarisi',
        ]);
    }
}