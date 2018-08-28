<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Instructor extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $dates = ['deleted_at'];

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

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
