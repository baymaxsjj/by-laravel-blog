<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Reply extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'reply', 'mess_id','user_id'
    ];
    protected $table= 'replies';
    protected $dates = ['deleted_at'];
    public function getDeletedAtAttribute($vlaue){
        $vlaue=is_null($vlaue)?1:0;
        return $vlaue;
    }
}
