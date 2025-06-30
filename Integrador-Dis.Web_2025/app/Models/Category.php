<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Course;

class Category extends Model
{
    protected $table = 'categories';
    protected $fillable = ['name', 'description'];

    public function Courses(){
        return $this->hasMany(Course::class, 'category_id');
    }
}
