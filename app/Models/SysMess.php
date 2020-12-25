<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class SysMess extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'id', 'title','content','logo','type','updated_at'
    ];
    protected $table= 'sysmess';
    protected $dates = ['deleted_at'];
}
