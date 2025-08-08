<?php

namespace Modules\LOMBRISOFT\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class HarvestActivity extends Model
{
    use HasFactory;

    protected $table = 'harvest_activities';

    protected $fillable = [
        'bed_activity_id',
        'tipo_recoleccion',
        'cantidad_recolectada',
    ];

    public function bedActivity()
    {
        return $this->belongsTo(BedActivity::class);
    }
}
