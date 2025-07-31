<?php

namespace Modules\LOMBRISOFT\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\LOMBRISOFT\Entities\WormBed;

class BedActivity extends Model
{
    use HasFactory;

    protected $table = 'bed_activities';

    protected $fillable = [
        'worm_bed_id',
        'tipo',
        'descripcion',
        'fecha_actividad',
        'hora_actividad',
        'cantidad_alimento',
        'tipo_alimento',
        'nivel_humedad',
        'tipo_recoleccion',
        'cantidad_recolectada',
        'ph',
        'temperatura',

    ];

    // Relación con cama
    public function wormBed()
    {
        return $this->belongsTo(WormBed::class, 'worm_bed_id');
    }
}
