<?php

namespace Modules\LOMBRISOFT\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeedingActivity extends Model
{
    use HasFactory;

    protected $table = 'feeding_activities';

    protected $fillable = [
        'bed_activity_id',
        'cantidad_alimento',
        'tipo_alimento',
    ];

    public function bedActivity()
    {
        return $this->belongsTo(BedActivity::class);
    }
}
