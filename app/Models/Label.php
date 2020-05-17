<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Label extends Model
{
    use SoftDeletes;
    //
    //
    // 接受的字段
    protected $fillable = [
        'label', 'user_id'
    ];
    protected $table= 'labels';
    public function article(){
      return $this->belongsTo('App\Models\Article','article_id','id');
    }
    // protected $dates = ['deleted_at'];
    // 表格隐藏的字段
    // protected $hidden = [
    //     ''
    // ];

}
