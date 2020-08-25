<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Reply;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Api\ReplyRequest;
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
    public function add(ReplyRequest $request){
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
        $mess='';
        if($mess_id==0){
            $mess="留言成功";
        }else{
            $mess="回复成功";
        }
        return $this->message($mess);
    }
    // 删除为0，
    public function remove(ReplyRequest $request){
        $id=$request->get('id');
        $message=Reply::withTrashed()->find($id);
        if($message->deleted_at==1){
            $boo=Reply::find($id)->delete();
            return $this->message('添加成功');
        }else{
            $boo=Reply::withTrashed()->find($id)->restore();
            return $this->message('移除成功');
        }
        // return $this->message($message->deleted_at);
    }
    public function list(ReplyRequest $request){
        $id=$request->input('id');
        $list=DB::table('replies')
            ->join('users','replies.user_id','=','users.id')
            ->where('mess_id',$id)
            ->select('replies.id','replies.reply','replies.created_at','users.name','users.avatar_url')
            ->get();
            // ->paginate(3);
        return $this->success($list);
    }
    public function alist(ReplyRequest $request){
        $mess_id=$request->get('id');
        $reply=Reply::withTrashed()->where('mess_id',$mess_id)->orderBy('created_at','desc')->get();
        return $this->success($reply);
    }
}