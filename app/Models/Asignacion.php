<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Asignacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'cod_doc',
        'cod_mat',
        'gestion_id',
        'activo',
        'turno',
        'paralelo',
        'slug',
    ];

    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }

    public function docente()
    {
        return $this->belongsTo(Docente::class, 'cod_doc', 'cod_doc');
    }

    public function materia()
    {
        return $this->belongsTo(Materia::class, 'cod_mat', 'cod_mat');
    }

    public function estudiantes()
    {
        return $this->belongsToMany(Estudiante::class, 'asignacion_estudiante')
                    ->using(AsignacionEstudiante::class)
                    ->withPivot(['activo', 'estado', 'eva_estado', 'nota_eva_doc'])
                    ->withTimestamps();
    }
}
