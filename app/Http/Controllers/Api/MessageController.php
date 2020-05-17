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
        if($userAuth){
            $message->user_id=$userAuth->id;
        }else{
            $tourist=$request->get('tourist');
            if($tourist){
                $message->tourist=$tourist;
            }else{
                return $this->failed('留言失败！登录失效',422);
            }
        }
        $message->article_id=$request->get('article_id');
        $message->message=$request->get('message');
        $message->save();
        return $this->message("留言成功");

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
        $list=Message::where('article_id',$id)->with(['user' => function($query) {
            $query->select(['id','name','avatar_url'])->get();
        },
        'reply' => function($query) {
           // $query->select(['mess_id','reply','created_at'])->get();
            $query->with(['user' => function($query) {
                $query->select(['id','name','avatar_url'])->get();
            }])->select(['user_id','mess_id','reply','created_at'])->get();
        },
        ])->select(['id','user_id','tourist','message','created_at'])
        ->orderBy('id','desc')
        ->paginate(10);
       // $user = $list->user;
       return $this->success( $list);
    }
    // 管理员获取列表
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
