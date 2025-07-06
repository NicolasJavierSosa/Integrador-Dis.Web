<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $table = 'inscripciones';

    protected $fillable = [
        'user_id',
        'curso_codigo',
        'fecha_inscripcion',
    ];

    protected $casts = [
        'fecha_inscripcion' => 'datetime',
    ];

    public function curso()
    {
        return $this->belongsTo(Course::class, 'curso_codigo', 'codigo');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
