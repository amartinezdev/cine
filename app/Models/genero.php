<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class genero extends Model
{
    use HasFactory;

    // Campos que se pueden rellenar masivamente
    protected $fillable = ['nombre'];

    // Relación: Un género tiene muchas películas
    public function peliculas()
    {
        return $this->hasMany(pelicula::class);
    }
}
