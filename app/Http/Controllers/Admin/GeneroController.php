<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\genero;
use Illuminate\Http\Request;

class GeneroController extends Controller
{
    // LISTAR todos los géneros
    public function index()
    {
        $generos = genero::orderBy('created_at', 'desc')->get();
        return view('admin.generos.index', compact('generos'));
    }

    // Mostrar formulario para CREAR
    public function create()
    {
        return view('admin.generos.create');
    }

    // GUARDAR nuevo género en BD
    public function crear(Request $request)
    {
        // Validar: nombre requerido, máx 255 caracteres, debe ser único
        $request->validate([
            'nombre' => 'required|string|max:255|unique:generos,nombre',
        ]);

        $newItem = new genero;
        $newItem->nombre = $request->input('nombre');
        $newItem->save();

        return redirect()->route('generos.index')->with('info', 'Género creado con éxito.');
    }

    // Mostrar formulario para EDITAR
    public function edit($id)
    {
        $genero = genero::findOrFail($id);
        return view("admin.generos.edit", compact('genero'));
    }

    // ACTUALIZAR género en BD
    public function actualizar(Request $request, $id)
    {
        // Validar: nombre único excepto para el registro actual (el ,$id)
        $request->validate([
            'nombre' => 'required|string|max:255|unique:generos,nombre,' . $id,
        ]);

        $item = genero::findOrFail($id);
        $item->nombre = $request->input('nombre');
        $item->save();

        return redirect()->route('generos.index')
            ->with('info', 'Género actualizado correctamente.');
    }

    // BORRAR género de BD
    public function delete($id)
    {
        $genero = genero::findOrFail($id);

        // Verificar si hay películas asociadas a este género
        if ($genero->peliculas()->count() > 0) {
            return redirect()->route('generos.index')
                ->with('error', 'No se puede eliminar el género porque tiene películas asociadas.');
        }

        $genero->delete();

        return redirect()->route('generos.index')
            ->with('info', 'Género eliminado exitosamente');
    }
}
