<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Api\MessageRequest;
use Illuminate\Support\Facades\DB;
class MessageController extends Controller
{
    //留言添加
    // 必填 message
    // 可选 article_id
    public function add(MessageRequest $request){
        $userAuth = Auth::guard('api')->user();
        $content=$request->input('message');
        $message=new Message();
        // 是否是为文章留言
        $article_id=$request->has('article_id') ? $request->input('artlcle_id'):0;
        $message->article_id=$article_id;
        $message->message=$content;
        $message->user_id=$userAuth->id;
        $message->save();
        return $this->success('留言成功');
    }
    // 留言删除
    // 必填 id
    public function remove(MessageRequest $request){
        $id=$request->input('id');
        $boo=Message::findOrFail($id)->delete();
        if($boo){
            return $this->success('删除成功');
        }
        return $this->failed('删除失败,可能已经删除了！');
    }
    public function list(MessageRequest $request){
        $id=$request->input('id');
        // $list=Message::where('article_id',$id)->paginate(5);
        // $list=DB::table('messages')->leftJoin('users','users.id','=','messages.user_id')->get
        // $list=DB::select('SELECT m.id,message,u.name,u.avatar_url FROM messages m INNER JOIN users u on u.id=m.user_id')->paginate(5);
        $list=DB::table('messages')
            ->join('users','messages.user_id','=','users.id')
            ->where('article_id',$id)
            ->select('messages.id','messages.message','messages.created_at','users.name','users.avatar_url')->paginate(3);
       
        return $this->success($list);
    }
}
