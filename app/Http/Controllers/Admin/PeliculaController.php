<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\pelicula;
use App\Models\genero;
use Illuminate\Http\Request;

class PeliculaController extends Controller
{
    // LISTAR todas las películas
    public function index()
    {
        $peliculas = pelicula::orderBy('created_at', 'desc')->get();
        return view('admin.peliculas.index', compact('peliculas'));
    }

    // Mostrar formulario para CREAR
    public function create()
    {
        $generos = genero::all();
        return view('admin.peliculas.create', compact('generos'));
    }

    // GUARDAR nueva película en BD
    public function crear(Request $request)
    {
        // Validar datos: título, sinopsis, duración, precio, género, imagen
        $request->validate([
            'titulo' => 'required|string|max:255',
            'sipnosis' => 'required|string',
            'duracion' => 'required|integer|min:1',
            'precio_entrada' => 'required|numeric|min:0',
            'genero_id' => 'required|exists:generos,id',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Crear película
        $newItem = new pelicula;
        $newItem->titulo = $request->input('titulo');
        $newItem->sipnosis = $request->input('sipnosis');
        $newItem->duracion = $request->input('duracion');
        $newItem->precio_entrada = $request->input('precio_entrada');
        $newItem->genero_id = $request->input('genero_id');
        $newItem->save();

        // Guardar imagen con spati
        if ($request->hasFile('poster')) {
            $newItem->addMediaFromRequest('poster')
                ->toMediaCollection('poster');
        }

        return redirect()->route('peliculas.index')->with('info', 'Película creada con éxito.');
    }

    // Mostrar formulario para EDITAR
    public function edit($id)
    {
        $pelicula = pelicula::findOrFail($id);
        $generos = genero::all();
        return view("admin.peliculas.edit", compact('pelicula', 'generos'));
    }

    // ACTUALIZAR película en BD
    public function actualizar(Request $request, $id)
    {
        // Validar datos
        $request->validate([
            'titulo' => 'required|string|max:255',
            'sipnosis' => 'required|string',
            'duracion' => 'required|integer|min:1',
            'precio_entrada' => 'required|numeric|min:0',
            'genero_id' => 'required|exists:generos,id',
            'poster' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Actualizar película
        $item = pelicula::findOrFail($id);
        $item->titulo = $request->input('titulo');
        $item->sipnosis = $request->input('sipnosis');
        $item->duracion = $request->input('duracion');
        $item->precio_entrada = $request->input('precio_entrada');
        $item->genero_id = $request->input('genero_id');
        $item->save();

        // Actualizar imagen si proporciona una nueva
        if ($request->hasFile('poster')) {
            $item->clearMediaCollection('poster');
            $item->addMediaFromRequest('poster')
                ->toMediaCollection('poster');
        }

        return redirect()->route('peliculas.index')
            ->with('info', 'Película actualizada correctamente.');
    }

    // BORRAR película de BD
    public function delete($id)
    {
        $pelicula = pelicula::findOrFail($id);
        $pelicula->delete();

        return redirect()->route('peliculas.index')
            ->with('info', 'Película eliminada exitosamente');
    }
}
