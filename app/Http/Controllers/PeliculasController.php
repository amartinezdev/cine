<?php

namespace App\Http\Controllers;

use App\Models\pelicula;
use App\Models\genero;
use App\Models\Promocion;
use Illuminate\Http\Request;

class PeliculasController extends Controller
{
    // Controlador público para listar películas con búsqueda y filtros
    public function index(Request $request)
    {
        // Iniciar consulta a la BD
        $query = pelicula::query();

        // Filtrar por título si el usuario proporciona uno
        if ($request->filled('titulo')) {
            $query->where('titulo', 'like', '%' . $request->titulo . '%');
        }

        // Filtrar por género si el usuario selecciona uno
        if ($request->filled('genero_id')) {
            $query->where('genero_id', $request->genero_id);
        }

        // Obtener películas ordenadas por las más nuevas
        $peliculas = $query->orderBy('created_at', 'desc')->get();
        // Obtener todos los géneros para el dropdown
        $generos = genero::all();

        // Obtener promociones activas
        $promocionesActivas = Promocion::activas()->get();

        return view('peliculas.index', compact('peliculas', 'generos', 'promocionesActivas'));
    }

    // Mostrar página de detalle de una película individual
    public function mostrarPagina($id)
    {
        $pelicula = pelicula::with('genero')->findOrFail($id);

        // Obtener promociones activas
        $promocionesActivas = Promocion::activas()->get();

        return view('peliculas.mostrarPagina', compact('pelicula', 'promocionesActivas'));
    }
}
