<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'sigla',
        'descripcion',
        'activo',
    ];

    public function materias()
    {
        return $this->hasMany(Materia::class);
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'carrera_estudiante');
    }
}
