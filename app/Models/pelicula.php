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
            ->height(450)
            // Sin esto, Glide intenta auto-orientar leyendo EXIF, y falla
            // en hostings sin la extension exif habilitada.
            ->orientation('0');
    }

    // Valoracion de la pelicula. No tenemos sistema de reseñas todavia,
    // asi que se calcula de forma estable a partir del titulo (misma
    // pelicula = misma nota siempre) para no mostrar el mismo numero
    // en toda la cartelera.
    public function getValoracionAttribute(): float
    {
        $semilla = crc32($this->titulo . '-' . $this->id);

        return round(6.5 + ($semilla % 36) / 10, 1);
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
