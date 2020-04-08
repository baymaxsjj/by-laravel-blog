<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Route extends Model
{
    //routes
    protected $fillable = [
        'data', 'category','content'
    ];
    protected $table= 'routes';
}
