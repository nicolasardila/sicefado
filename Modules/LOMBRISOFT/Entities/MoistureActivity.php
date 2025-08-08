<?php

namespace Modules\LOMBRISOFT\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MoistureActivity extends Model
{
    use HasFactory;

    protected $table = 'moisture_activities';

    protected $fillable = [
        'bed_activity_id',
        'nivel_humedad',
    ];

    public function bedActivity()
    {
        return $this->belongsTo(BedActivity::class);
    }
}
