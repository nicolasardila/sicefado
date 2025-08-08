<?php

namespace Modules\LOMBRISOFT\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PhActivity extends Model
{
    use HasFactory;

    protected $table = 'ph_activities';

    protected $fillable = [
        'bed_activity_id',
        'ph',
    ];

    public function bedActivity()
    {
        return $this->belongsTo(BedActivity::class);
    }
}
