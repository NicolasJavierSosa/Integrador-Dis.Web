<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name', 'description'];

    public function Courses(){
        return $this->hasMany(Curso::class, 'category_id');
    }
}
