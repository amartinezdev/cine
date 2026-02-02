<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PeliculasController;
use App\Http\Controllers\Admin\GeneroController;
use App\Http\Controllers\Admin\PeliculaController;
use App\Http\Controllers\Admin\PromocionController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [PeliculasController::class, 'index'])->name('inicio');

Route::get('/pelicula/{id}', [PeliculasController::class, 'mostrarPagina'])->name('pelicula.mostrarPagina');

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('generos', [GeneroController::class, 'index'])->name("generos.index");
    Route::get('generos/create', [GeneroController::class, 'create'])->name("generos.create");
    Route::post('generos', [GeneroController::class, 'crear'])->name("generos.crear");
    Route::delete('generos/{id}', [GeneroController::class, 'delete'])->name("generos.delete");
    Route::get('generos/edit/{id}', [GeneroController::class, 'edit'])->name("generos.edit");
    Route::put('generos/{id}', [GeneroController::class, 'actualizar'])->name('generos.actualizar');

    Route::get('peliculas', [PeliculaController::class, 'index'])->name("peliculas.index");
    Route::get('peliculas/create', [PeliculaController::class, 'create'])->name("peliculas.create");
    Route::post('peliculas', [PeliculaController::class, 'crear'])->name("peliculas.crear");
    Route::delete('peliculas/{id}', [PeliculaController::class, 'delete'])->name("peliculas.delete");
    Route::get('peliculas/edit/{id}', [PeliculaController::class, 'edit'])->name("peliculas.edit");
    Route::put('peliculas/{id}', [PeliculaController::class, 'actualizar'])->name('peliculas.actualizar');

    Route::get('promociones', [PromocionController::class, 'index'])->name("promociones.index");
    Route::get('promociones/create', [PromocionController::class, 'create'])->name("promociones.create");
    Route::post('promociones', [PromocionController::class, 'crear'])->name("promociones.crear");
    Route::delete('promociones/{id}', [PromocionController::class, 'delete'])->name("promociones.delete");
    Route::get('promociones/edit/{id}', [PromocionController::class, 'edit'])->name("promociones.edit");
    Route::put('promociones/{id}', [PromocionController::class, 'actualizar'])->name('promociones.actualizar');
});

require __DIR__ . '/auth.php';
