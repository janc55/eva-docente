<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'nombre',
        'gestion',
        'periodo',
        'fecha_inicio',
        'fecha_fin',
        'activo',
    ];

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class);
    }
}
