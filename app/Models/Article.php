<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Redis;
class Article extends Model
{
    use SoftDeletes;
     // 接受的字段
    protected $fillable = [
        'title', 'desc','content','img','classty','name','deleted_at','click','like','is_show','head_show','share_show','copyright_show','message_show','deleted_at'
    ];
    public function label(){
      return $this->hasMany('App\Models\Label','article_id','id');
    }
    protected $table= 'articles';
    // 表格隐藏的字段
    protected $dates = ['deleted_at'];
    // 修改器
    public function getDeletedAtAttribute($vlaue){
        $vlaue=is_null($vlaue)?1:0;
        return $vlaue;
    }
    // 正向关联
    public function message(){
      return $this->hasMany('App\Models\Message','article_id','id');
    }

     public function visits()
        {
            return visits($this);
        }
}
