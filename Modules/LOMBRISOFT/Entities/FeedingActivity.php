<?php

namespace Modules\LOMBRISOFT\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\LOMBRISOFT\Entities\WormBed;

class FeedingActivity extends Model
{
    use HasFactory;

    protected $table = 'feeding_activitys';

    protected $fillable = [
        'worm_bed_id',
        'tipo_alimento',
        'cantidad',
        'observaciones',
        'fecha_hora'
    ];

    public $timestamps = false;

    public function cama()
    {
        return $this->belongsTo(WormBed::class, 'worm_bed_id');
    }
}
