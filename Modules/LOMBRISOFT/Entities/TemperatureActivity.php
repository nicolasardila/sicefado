<?php

namespace Modules\LOMBRISOFT\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TemperatureActivity extends Model
{
    use HasFactory;

    protected $table = 'temperature_activities';

    protected $fillable = [
        'bed_activity_id',
        'temperatura',
    ];

    public function bedActivity()
    {
        return $this->belongsTo(BedActivity::class);
    }
}
