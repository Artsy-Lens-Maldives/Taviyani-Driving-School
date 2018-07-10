<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    public function time()
    {
        return $this->belongsTo('App\Time', 'time_id');
    }

    public function instructor()
    {
        return $this->belongsTo('App\Instructor', 'instructor_id');
    }

    public function student()
    {
        return $this->belongsTo('App\Student', 'student_id');
    }
}
