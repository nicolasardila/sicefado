<?php

// Modules/LOMBRISOFT/Entities/Activity.php
namespace Modules\LOMBRISOFT\Entities;

use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    protected $table = 'activities';

    protected $fillable = [
        'worm_bed_id',
        'type', // 'mantenimiento', 'alimentacion', 'humedad', 'recoleccion'
        'activity_id', // ID de la actividad específica relacionada
        'fecha'
    ];

    public function wormBed()
    {
        return $this->belongsTo(WormBed::class, 'worm_bed_id');
    }
}
