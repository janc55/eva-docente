<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estudiante extends Model
{
    use HasFactory;

    protected $fillable = [
        'cod_est', 
        'nombre', 
        'apellido_paterno',
        'apellido_materno', 
        'ci',
        'complemento_ci', 
        'celular', 
        'foto',
        'activo', 
        'user_id'
    ];

    public function carreras()
    {
        return $this->belongsToMany(Carrera::class, 'carrera_estudiante');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function asignaciones()
    {
        return $this->belongsToMany(Asignacion::class, 'asignacion_estudiante', 'estudiante_id', 'asignacion_id')
            ->using(AsignacionEstudiante::class)
            ->withPivot(['activo', 'estado', 'eva_estado', 'nota_eva_doc'])
            ->withTimestamps();
    }

    public function vistaNombre()
    {
        return $this->belongsTo(VistaNombre::class, 'id', 'id');
    }
}
