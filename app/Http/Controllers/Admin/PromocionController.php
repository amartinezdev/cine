<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promocion;
use Illuminate\Http\Request;

class PromocionController extends Controller
{
    // LISTAR todas las promociones
    public function index()
    {
        $promociones = Promocion::orderBy('created_at', 'desc')->get();
        return view('admin.promociones.index', compact('promociones'));
    }

    // Mostrar formulario para CREAR
    public function create()
    {
        return view('admin.promociones.create');
    }

    // GUARDAR nueva promoción en BD
    public function crear(Request $request)
    {
        // Validar: campos requeridos y fecha_fin > fecha_inicio
        $request->validate([
            'titulo' => 'required|string|max:255',
            'mensaje' => 'required|string',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after:fecha_inicio',
        ], [
            'fecha_fin.after' => 'La fecha fin debe ser posterior a la fecha inicio.',
        ]);

        $newItem = new Promocion;
        $newItem->titulo = $request->input('titulo');
        $newItem->mensaje = $request->input('mensaje');
        $newItem->fecha_inicio = $request->input('fecha_inicio');
        $newItem->fecha_fin = $request->input('fecha_fin');
        $newItem->save();

        return redirect()->route('promociones.index')->with('info', 'Promoción creada con éxito.');
    }

    // Mostrar formulario para EDITAR
    public function edit($id)
    {
        $promocion = Promocion::findOrFail($id);
        return view("admin.promociones.edit", compact('promocion'));
    }

    // ACTUALIZAR promoción en BD
    public function actualizar(Request $request, $id)
    {
        $promocion = Promocion::findOrFail($id);
        $promocion->titulo = $request->input('titulo');
        $promocion->mensaje = $request->input('mensaje');
        $promocion->fecha_inicio = $request->input('fecha_inicio');
        $promocion->fecha_fin = $request->input('fecha_fin');
        $promocion->save();

        return redirect()->route('promociones.index')->with('info', 'Promoción actualizada con éxito.');
    }

    // ELIMINAR promoción
    public function delete($id)
    {
        $promocion = Promocion::findOrFail($id);
        $promocion->delete();

        return redirect()->route('promociones.index')->with('info', 'Promoción eliminada con éxito.');
    }
}
