<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class pelicula extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

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

    // Configurar colección de media (imágenes) para la película
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('poster')
            ->singleFile(); // Solo una imagen por película
    }

    // Crear conversiones de imagen (miniatura de 300x450)
    public function registerMediaConversions($media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(450);
    }

    // Obtener URL de la imagen del poster
    public function getPosterUrl()
    {
        if ($this->hasMedia('poster')) {
            return $this->getFirstMediaUrl('poster');
        }
        return null;
    }
}
