<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Reply extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'reply', 'mess_id','mess_reply_id','ip','address','created_at'
    ];
	// 反向关联
    public function user(){
      return $this->belongsTo('App\Models\User','user_id','id');
    }
    public function messReply(){
      return $this->hasMany('App\Models\Reply','id','mess_reply_id');
    }
    protected $table= 'replies';
    protected $dates = ['deleted_at'];
    public function getDeletedAtAttribute($vlaue){
        $vlaue=is_null($vlaue)?1:0;
        return $vlaue;
    }

}
 // 'reply' => function($query) {
        //     $query->select(['mess_id','reply','created_at'])->get();
        // },
