<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Curso extends Model
{
    use HasFactory;

    protected $table = 'cursos'; 
    protected $primaryKey = 'codigo'; 
    public $incrementing = false;
    protected $keyType = 'string';

    protected $fillable = [
        'codigo',
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'fecha_limite_inscripcion',
        'cupo',
        'costo_inscripcion',
        'costo_mensual',
        'horario',
    ];

    protected $dates = [
        'fecha_inicio',
        'fecha_fin',
        'fecha_limite_inscripcion',
        'horario',
    ];
}
