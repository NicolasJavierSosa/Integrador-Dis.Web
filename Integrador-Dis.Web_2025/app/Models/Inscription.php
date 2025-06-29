<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inscription extends Model
{
    use HasFactory;

    protected $table = 'inscriptions';

    protected $fillable = [
        'user_id',
        'curso_id',
        'status',
        'amount_id',
        'notes',
        'inscripcion_date'
    ];

    protected $casts = [
        'inscripciones_date' => 'datetime',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function course() {
        return $this->belongsTo(Curso::class);
    }
}
