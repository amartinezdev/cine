<?php

namespace Database\Seeders;

use App\Models\genero;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class GeneroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Lista de géneros de películas a crear
        $generos = [
            'Acción',
            'Drama',
            'Ciencia Ficción',
            'Comedia',
            'Terror',
            'Romance',
            'Thriller',
            'Animación',
            'Aventura',
            'Crimen'
        ];

        // Crear un registro de género por cada uno
        foreach ($generos as $nombre) {
            genero::create([
                'nombre' => $nombre,
            ]);
        }
    }
}
