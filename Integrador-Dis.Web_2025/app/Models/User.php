<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Models\Inscription;
use App\Models\Course;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'role',
        'dni',
        'name',
        'surname',
        'gender',
        'birth_date',
        'email',
        'address',
        'phone',
        'password',
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

    public function cursos()
{
    return $this->belongsToMany(Curso::class, 'inscripciones', 'user_id', 'curso_codigo')
               ->withPivot('inscripcion_date')
               ->withTimestamps();
}


    public function inscripciones()
    {
        return $this->hasMany(Inscription::class);
    }


}
