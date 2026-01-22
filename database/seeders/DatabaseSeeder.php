<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Crear enlace simbólico storage -> public/storage si no existe
        $this->createStorageLink();

        $this->call([
            UserSeeder::class,
            GeneroSeeder::class,
            PeliculaSeeder::class,
        ]);
    }

    /**
     * Enlace simbólico para Spatie Media Library
     */
    private function createStorageLink(): void
    {
        $publicStoragePath = public_path('storage');

        if (!File::exists($publicStoragePath)) {
            Artisan::call('storage:link');
            $this->command->info('Enlace simbólico storage creado correctamente.');
        }
    }
}
