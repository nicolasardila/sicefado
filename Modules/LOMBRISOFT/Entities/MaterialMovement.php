<?php

namespace Modules\LOMBRISOFT\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\LOMBRISOFT\Entities\Material;

class MaterialMovement extends Model
{
    use HasFactory;

    protected $table = 'material_movements';

    protected $fillable = [
        'material_id',
        'tipo',
        'cantidad',
        'descripcion',
        'fecha_movimiento',
    ];

    public $timestamps = true; // Para usar created_at y updated_at

    /**
     * Relación con el material.
     */
    public function material()
    {
        return $this->belongsTo(Material::class, 'material_id');
    }

    /**
     * Método para la factory (opcional).
     */
    protected static function newFactory()
    {
        return \Modules\LOMBRISOFT\Database\factories\MaterialMovementFactory::new();
    }
}
