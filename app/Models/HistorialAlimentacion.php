<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialAlimentacion extends Model
{
    use HasFactory;

    protected $table = 'historial_alimentaciones';

    protected $fillable = [
        'mascota_id',
        'consulta_id',
        'tipo_comida',
        'frecuencia',
        'detalles',
        'condicion',
        'recomendacion',
    ];

    protected $casts = [
        'frecuencia' => 'array',
    ];

    public function mascota()
    {
        return $this->belongsTo(Mascota::class);
    }

    public function consulta()
    {
        return $this->belongsTo(Consulta::class);
    }
}
