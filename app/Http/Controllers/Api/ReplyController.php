<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reply;

class ReplyController extends Controller
{
    // 评论回复逻辑
    //SELECT * FROM `messages` m  LEFT JOIN replies r on m.id=r.mess_id where m.`article_id`=0  
    // ORDER BY `m`.`id`  DESC
    //
    // 用户添加留言可接受参数
    //      评论内容    留言id
    // 必填 reply   mess_id
    // 可选 user_id 评论用户id
    public function add(Request $request){
        $reply=$request->input('reply');
        $mess_id=$request->input('mess_id');
        $userAuth = Auth::guard('api')->user();
        // 存在：用户评论
        // 不存在：管理员评论
        // $atricle_id=$request->has('user_id')?$request-input('user_id'):0;
        // $userAuth->is_admin?
        $re=new Reply();
        $re->reply=$reply;
        $re->user_id=$userAuth->id;
        $re->mess_id=$mess_id;
        $re->save();
        return $this->success('留言成功'.$reply);
    }
    public function remove(Request $request){
        $id=$request->input('id');
        $boo=Reply::findOrFail($id)->delete();
        if($boo){
            return $this->success('删除成功');
        }
        return $this->failed('删除失败,可能已经删除了！');
    }
}
