<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Message;
use App\Models\Reply;
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
        $id=$request->get('id');
        $message=Message::withTrashed()->find($id);
        if( is_null($message->deleted_at)){
            $boo=Message::find($id)->delete();
            return $this->message('添加成功');
        }else{
            $boo=Message::withTrashed()->find($id)->restore();
            return $this->message('移除成功');
        }
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
    public function alist(Request $request){
        $message=Message::withTrashed()->orderBy('created_at','desc')->paginate(5);
        foreach($message as $item){
            $reply=Reply::withTrashed()->where('mess_id',$item->id)->count();
            if($reply){
                $item->hasChildren = true;
            }
        }
        return $this->success($message);
    }
}
