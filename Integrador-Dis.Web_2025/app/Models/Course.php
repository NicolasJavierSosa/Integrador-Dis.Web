<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Course extends Model
{
    use HasFactory;

    protected $table = 'cursos';
    protected $primaryKey = 'codigo';  // Clave primaria personalizada
    public $incrementing = true;      // Clave string, no autoincremental
    protected $keyType = 'integer';     // Es string

    //modalidad
    //dia
    protected $fillable = [
        'nombre',
        'descripcion',
        'fecha_inicio',
        'fecha_fin',
        'fecha_limite_inscripcion',
        'cupo',
        'costo_inscripcion',
        'costo_mensual',
        'horario',
        'modalidad',
        'dias',
    ];

    protected $casts = [
        'fecha_inicio' => 'date',
        'fecha_fin' => 'date',
        'fecha_limite_inscripcion' => 'date',
        'horario' => 'array',
        'dias' => 'array',
    ];

    public function usuarios()
    {
        return $this->belongsToMany(
            User::class,
            'inscripciones',
            'curso_codigo',
            'user_id'
        )->withPivot('fecha_inscripcion') // <-- COINCIDE con la migración
        ->withTimestamps();
    }


}
