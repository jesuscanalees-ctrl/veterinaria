<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Scout\Searchable;

class Mascota extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'dueno_id',
        'nombre',
        'especie',
        'raza',
        'fecha_nacimiento',
        'tipo_sangre',
        'comportamiento',
        'es_adoptado',
        'alergias',
        'lesiones',
        'patologicos',
        'alimentacion',
    ];

    public function dueno()
    {
        return $this->belongsTo(Dueno::class);
    }

    public function consultas()
    {
        return $this->hasMany(Consulta::class);
    }

    public function historialAlimentacion()
    {
        return $this->hasMany(HistorialAlimentacion::class)->orderByDesc('created_at');
    }

    public function historialPatologico()
    {
        return $this->hasMany(HistorialPatologico::class)->orderByDesc('created_at');
    }

    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
        ];
    }
}
