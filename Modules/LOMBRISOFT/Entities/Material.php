<?php

namespace Modules\LOMBRISOFT\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Material extends Model
{
    use HasFactory;

    protected $table = 'materials';

    protected $fillable = [
        'nombre',
        'estado',
        'cantidad',
        'fecha_registro'
    ];

    public $timestamps = false;

    // Añadir atributo computado al JSON
    protected $appends = ['estado_texto'];

    // Devuelve "Disponible" o "No Disponible"
    public function getEstadoTextoAttribute()
    {
        return $this->estado ? 'Disponible' : 'No Disponible';
    }

    // Fábrica para Material (si la tienes)
    protected static function newFactory()
    {
        return \Modules\LOMBRISOFT\Database\factories\MaterialFactory::new();
    }
}
