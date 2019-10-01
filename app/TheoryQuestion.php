<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheoryQuestion extends Model
{
    protected $guarded = [];
    
    public function answers()
    {
        return $this->hasMany('App\TheoryAnswer', 'question_id');
    }
}
