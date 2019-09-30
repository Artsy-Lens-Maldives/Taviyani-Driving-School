<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function instructor()
    {
        return $this->belongsTo('App\Instructor');
    }

    public function categories()
    {
        return $this->belongsToMany('App\Category');
    }

    public function slot()
    {
        return $this->hasOne('App\Slot', 'student_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function location()
    {
        return $this->belongsTo('App\Location');
    }

    public function scopeGetTotalPrice($query, $month, $year) {
        return $query->where('month', $month)->where('year', $year)->sum('rate');
    }
}
