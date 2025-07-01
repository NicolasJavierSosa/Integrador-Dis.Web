<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $table = 'inscripciones';

public function curso() {
    return $this->belongsTo(Course::class, 'curso_codigo', 'codigo');
}

    protected $fillable = [
        'user_id',
        'curso_id',
        'status',
        'amount_id',
        'notes',
        'fecha_inscripcion'
    ];

    protected $casts = [
        'inscripciones_date' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

}
