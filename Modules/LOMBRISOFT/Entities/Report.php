<?php

namespace Modules\LOMBRISOFT\Entities;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    protected $table = 'reports';
    protected $fillable = ['worm_bed_id', 'activity_id', 'observaciones', 'fecha'];

    public $timestamps = false; // <-- Agrega esta línea

    public function wormBed()
    {
        return $this->belongsTo(WormBed::class, 'worm_bed_id');
    }

    public function activity()
    {
        return $this->belongsTo(BedActivity::class, 'activity_id');
    }
}
