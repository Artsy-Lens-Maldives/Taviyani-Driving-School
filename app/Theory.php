<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Theory extends Model
{
    public function questions()
    {
        return $this->hasMany('App\TheoryQuestion', 'theory_id')->take(5);
    }
}
