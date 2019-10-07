<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Nicolaslopezj\Searchable\SearchableTrait;

class Address extends Model
{
    use SearchableTrait;

    protected $guarded = [];
    protected $connection = 'mysql2';
    protected $table = 'addresses';

    protected $searchable = [
        'columns' => [
            'addresses.name' => 10,
        ],
    ];
}
