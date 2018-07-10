<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Time extends Model
{
    public function slots()
    {
        return $this->hasMany('App\Slot', 'time_id');
    }
}
