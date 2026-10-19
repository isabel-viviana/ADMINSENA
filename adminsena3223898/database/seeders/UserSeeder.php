<?php

namespace Database\Seeders;

use App\Models\People\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@sena.com'],
            [
                'name' => 'Administrador',
                'password' => Hash::make('123456'),
                'role' => 'admin',
            ]
        );

        User::updateOrCreate(
            ['email' => 'aprendiz@sena.com'],
            [
                'name' => 'Aprendiz',
                'password' => Hash::make('123456'),
                'role' => 'aprendiz',
            ]
        );
    }
}
