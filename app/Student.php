<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Student extends Model
{
    use SoftDeletes;

    protected $guarded = [];
    protected $dates = ['deleted_at'];

    public function category()
    {
        return $this->belongsTo('App\Category', 'category_id');
    }

    public function slot()
    {
        return $this->hasOne('App\Slot', 'student_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
