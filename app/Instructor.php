<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Instructor extends Model
{
    protected $guarded = [];

    public function slots()
    {
        return $this->hasMany('App\Slot', 'instructor_id');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category', 'category_instructor', 'instructor_id', 'category_id');
    }

    public function location()
    {
        return $this->belongsTo('App\Location', 'location_id');
    }
}
