<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Curso extends Model
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
    ];

    protected $casts = [
        'fecha_inicio',
        'fecha_fin',
        'fecha_limite_inscripcion',
        'horario',
    ];

    // 🔑 Relación Many-to-Many hacia User usando tabla pivot
    public function usuarios()
    {
        return $this->belongsToMany(
            User::class,        // Modelo relacionado
            'inscripcions',     // Tabla pivot
            'curso_codigo',     // FK de Curso en pivot
            'user_id',          // FK de User en pivot
            'codigo',           // Clave local en Curso
            'id'                // Clave local en User
        );
    }
}
