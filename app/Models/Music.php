<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Music extends Model
{
    //
    use SoftDeletes;
    protected $fillable = [
        'music_id', 'title','name','type'
    ];
    protected $table= 'musics';
    protected $dates = ['deleted_at'];
}
