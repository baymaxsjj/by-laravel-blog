<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Route extends Model
{
   use SoftDeletes;
    //routes
    protected $fillable = [
        'data', 'category','content'
    ];
    protected $table= 'routes';
    protected $dates = ['deleted_at'];
}
