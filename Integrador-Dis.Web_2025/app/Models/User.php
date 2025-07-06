<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
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
        return $this->belongsToMany(
            Course::class, 
            'inscripciones', 
            'user_id', 
            'curso_codigo'
        )->withPivot('fecha_inscripcion')
         ->withTimestamps();
    }

    public function inscripciones()
    {
        return $this->hasMany(Inscription::class);
    }

    public function showForm()
    {
        // Obtener los usuarios con el rol 'teacher'
        $docentes = User::role('teacher')->get(['dni', 'name']); // Solo obtenemos el dni y el nombre

        
        return view('admin.courses', compact('docentes'));
    }

    public function getFullNameAttribute()
    {
        return "{$this->name} {$this->surname}";
    }

}
