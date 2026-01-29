<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promocion extends Model
{
    use HasFactory;

    // Campos que se pueden rellenar
    protected $fillable = [
        'titulo',
        'mensaje',
        'fecha_inicio',
        'fecha_fin',
        'activo'
    ];

    protected $casts = [
        'fecha_inicio' => 'datetime',
        'fecha_fin' => 'datetime',
        'activo' => 'boolean',
    ];

    // Scope para obtener promociones activas (campo activo + dentro del rango de fechas)
    public function scopeActivas($query)
    {
        $ahora = now();
        return $query->where('activo', true)
            ->where('fecha_inicio', '<=', $ahora)
            ->where('fecha_fin', '>=', $ahora);
    }

    // Scope para obtener promociones inactivas
    public function scopeInactivas($query)
    {
        return $query->where('activo', false);
    }
}
