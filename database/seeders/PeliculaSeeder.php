<?php

namespace Database\Seeders;

use App\Models\pelicula;
use App\Models\genero;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class PeliculaSeeder extends Seeder
{
    public function run()
    {
        // Obtener todos los géneros que ya existen en la BD
        $generos = genero::all();

        // Datos de las películas: título, sinopsis, duración, precio, género e imagen
        $peliculas = [
            [
                'titulo' => 'Matrix',
                'sipnosis' => 'Un hacker descubre la verdadera naturaleza de su realidad y su papel en la guerra contra los controladores de ella.',
                'duracion' => 136,
                'precio_entrada' => 9.99,
                'genero_id' => $generos->where('nombre', 'Ciencia Ficción')->first()->id,
                'image_file' => 'matrix.png',
            ],
            [
                'titulo' => 'El Padrino',
                'sipnosis' => 'La historia del imperio criminal Corleone y cómo su hijo Michael se convierte en el nuevo líder de la familia.',
                'duracion' => 175,
                'precio_entrada' => 8.99,
                'genero_id' => $generos->where('nombre', 'Crimen')->first()->id,
                'image_file' => 'el_padrino.png',
            ],
            [
                'titulo' => 'Inception',
                'sipnosis' => 'Un ladrón especializado en extraer secretos de los sueños es contratado para hacer lo opuesto: implantar una idea.',
                'duracion' => 148,
                'precio_entrada' => 9.99,
                'genero_id' => $generos->where('nombre', 'Ciencia Ficción')->first()->id,
                'image_file' => 'inception.png',
            ],
            [
                'titulo' => 'Interestelar',
                'sipnosis' => 'Un grupo de astronautas viaja a través de un agujero de gusano para encontrar un nuevo hogar para la humanidad.',
                'duracion' => 169,
                'precio_entrada' => 10.99,
                'genero_id' => $generos->where('nombre', 'Ciencia Ficción')->first()->id,
                'image_file' => 'interstellar.png',
            ],
            [
                'titulo' => 'Vengadores: Endgame',
                'sipnosis' => 'Los Vengadores se reúnen para una batalla final contra Thanos y restaurar el balance del universo.',
                'duracion' => 181,
                'precio_entrada' => 11.99,
                'genero_id' => $generos->where('nombre', 'Acción')->first()->id,
                'image_file' => 'avengers.png',
            ],
            [
                'titulo' => 'The Shining',
                'sipnosis' => 'Una familia se queda aislada durante el invierno en un hotel de montaña donde fuerzas sobrenaturales los acosan.',
                'duracion' => 146,
                'precio_entrada' => 7.99,
                'genero_id' => $generos->where('nombre', 'Terror')->first()->id,
                'image_file' => 'the_shining.png',
            ],
            [
                'titulo' => 'Forrest Gump',
                'sipnosis' => 'La vida de un hombre con discapacidad intelectual que, a pesar de sus limitaciones, logra cosas extraordinarias.',
                'duracion' => 142,
                'precio_entrada' => 8.99,
                'genero_id' => $generos->where('nombre', 'Drama')->first()->id,
                'image_file' => 'forrest_gump.png',
            ],
            [
                'titulo' => 'Titanic',
                'sipnosis' => 'La historia de amor entre dos pasajeros de diferentes clases en el hundimiento del RMS Titanic.',
                'duracion' => 194,
                'precio_entrada' => 9.99,
                'genero_id' => $generos->where('nombre', 'Romance')->first()->id,
                'image_file' => 'titanic.png',
            ],
            [
                'titulo' => 'Mad Max: Fury Road',
                'sipnosis' => 'En un futuro post-apocalíptico, un policía y una revolucionaria huyen a través del desierto en una persecución épica.',
                'duracion' => 120,
                'precio_entrada' => 9.99,
                'genero_id' => $generos->where('nombre', 'Acción')->first()->id,
                'image_file' => 'mad_max.png',
            ],
            [
                'titulo' => 'Pulp Fiction',
                'sipnosis' => 'Múltiples historias entrelazadas de criminales, gángsters, boxeadores y damas de compañía en Los Ángeles.',
                'duracion' => 154,
                'precio_entrada' => 8.99,
                'genero_id' => $generos->where('nombre', 'Crimen')->first()->id,
                'image_file' => 'pulp_fiction.png',
            ],
        ];

        // Rutas: origen (en el proyecto) y destino (en almacenamiento público)
        $sourceDir = database_path('seeders/images'); // Carpeta con imágenes locales
        $destDir = storage_path('app/public/peliculas'); // Carpeta de destino para fotos

        // Crear carpeta de destino si no existe
        if (!File::exists($destDir)) {
            File::makeDirectory($destDir, 0755, true);
        }

        // Iterar sobre cada película y guardar en BD con imagen
        foreach ($peliculas as $peliculaData) {
            // Extraer nombre de archivo de imagen
            $imageFile = $peliculaData['image_file'] ?? null;
            unset($peliculaData['image_file']);

            // Crear registro de película en BD
            $pelicula = pelicula::create($peliculaData);

            // Si hay imagen: copiar a storage y vincular con Spatie Media Library
            if ($imageFile) {
                $sourcePath = $sourceDir . '/' . $imageFile;
                $destPath = $destDir . '/' . $imageFile;

                // Si el archivo existe en el proyecto, copiarlo a storage
                if (File::exists($sourcePath)) {
                    // Copiar (no mover) el archivo a storage
                    File::copy($sourcePath, $destPath);

                    // Agregar el archivo copiado a Spatie
                    $pelicula->addMedia($destPath)
                        ->preservingOriginal()
                        ->toMediaCollection('poster');
                }
            }
        }
    }
}
