<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usuarios = [
            [
                'name' => 'Administrador',
                'email' => '1@gmail.com',
                'password' => Hash::make('1'),
                'admin' => true,
            ],

            [
                'name' => 'Álvaro',
                'email' => 'alvaro@gmail.com',
                'password' => Hash::make('1'),
                'admin' => false,
            ],
            [
                'name' => 'Uri Malo',
                'email' => 'uri@gmail.com',
                'password' => Hash::make('1'),
                'admin' => false,
            ],
            [
                'name' => 'Edu',
                'email' => 'edu@gmail.com',
                'password' => Hash::make('1'),
                'admin' => false,
            ],
            [
                'name' => 'Hamza',
                'email' => 'hamza@gmail.com',
                'password' => Hash::make('1'),
                'admin' => false,
            ],
        ];

        foreach ($usuarios as $usuario) {
            User::create($usuario);
        }
    }
}
