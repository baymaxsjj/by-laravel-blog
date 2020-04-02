<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{   
    
    protected $fillable = [
        'reply', 'mess_id','user_id'
    ];
    protected $table= 'replies';
}
