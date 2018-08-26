<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TempStudent extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function instructor()
    {
        return $this->belongsTo('App\Instructor', 'instructor_id');
    }
}
