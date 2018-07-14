<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Transportfee extends Model
{
    protected $guarded = [];
    protected $dates = [
        'date',
        'created_at',
        'updated_at'
    ];

    public function student()
    {
        return $this->belongsTo('App\Student', 'student_id');
    }
}
