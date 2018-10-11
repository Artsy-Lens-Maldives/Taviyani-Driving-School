<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TheoryAnswer extends Model
{
    public function question()
    {
        return $this->hasOne('App\Question', 'question_id');
    }
}
