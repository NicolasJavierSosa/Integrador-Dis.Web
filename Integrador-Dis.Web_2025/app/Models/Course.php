<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Inscription;

class Course extends Model
{
    protected $table = 'courses';

    protected $fillable = [
        'name',
        'description',
        'category',
        'owner',
        'begin_date',
        'end_date',
        'insc_date_limit',
        'quota',
        'mode',
        'insc_cost',
        'month_cost',
        'schedule',
        'days'
    ];

    public function inscriptions() {
        return $this->hasMany(Inscription::class);
    }

    public function users() {
        return $this->belongsToMany(User::class, 'inscriptions')->withPivot('inscription_date')->withTimestamps();
    }
}
