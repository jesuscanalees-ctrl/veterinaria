<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistorialPatologico extends Model
{
    use HasFactory;

    protected $table = 'historial_patologicos';

    protected $fillable = [
        'mascota_id',
        'consulta_id',
        'categoria',
        'descripcion',
        'medicamentos',
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
