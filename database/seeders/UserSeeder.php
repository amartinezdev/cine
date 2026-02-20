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
        // Cuentas de demostración: se recrean cada noche junto con el resto de datos.
        // Las credenciales se muestran también en la pantalla de login.
        $usuarios = [
            [
                'name' => 'Admin Demo',
                'email' => 'admin@demo.com',
                'password' => Hash::make('CineDemo2026!'),
                'admin' => true,
            ],
            [
                'name' => 'Usuario Demo',
                'email' => 'user@demo.com',
                'password' => Hash::make('CineDemo2026!'),
                'admin' => false,
            ],
        ];

        foreach ($usuarios as $usuario) {
            User::create($usuario);
        }
    }
}
