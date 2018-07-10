<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function slot()
    {
        return $this->hasOne('App\Slot', 'student_id');
    }
}
