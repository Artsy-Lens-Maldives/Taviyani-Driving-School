<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function instructors()
    {
        return $this->belongsToMany('App\Instructor', 'category_instructor', 'category_id', 'instructor_id');
    }
}
