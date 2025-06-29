<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'dni',
        'phone',
        'address',
        'birth_date',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // 🔑 Relación Many-to-Many hacia Curso usando tabla pivot
    public function cursos()
    {
        return $this->belongsToMany(
            Curso::class,       // Modelo relacionado
            'inscripcions',     // Tabla pivot
            'user_id',          // FK de User en pivot
            'curso_codigo',     // FK de Curso en pivot
            'id',               // Clave local en User
            'codigo'            // Clave local en Curso
        );
    }
}
