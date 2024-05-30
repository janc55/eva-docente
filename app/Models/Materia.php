<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    use HasFactory;

    protected $primaryKey = 'id'; // Clave primaria autoincremental

    protected $fillable = [
        'cod_mat',
        'nombre',
        'sigla',
        'descripcion',
        'semestre',
        'carrera_id',
    ];

    public function carrera()
    {
        return $this->belongsTo(Carrera::class);
    }

    public function asignaciones()
    {
        return $this->hasMany(Asignacion::class, 'cod_mat', 'cod_mat');
    }


}
