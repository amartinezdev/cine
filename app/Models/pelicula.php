<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pelicula extends Model
{
    use HasFactory;

    // Campos que se pueden rellenar masivamente
    protected $fillable = [
        'titulo',
        'sipnosis',
        'duracion',
        'precio_entrada',
        'genero_id',
    ];

    // Relación: Una película pertenece a un género
    public function genero()
    {
        return $this->belongsTo(genero::class);
    }
}
