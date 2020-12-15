<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Message;
use App\Models\Reply;
use App\Models\Article;
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
        $message->user_id=$userAuth->user_id;
        $articles=Article::where('id',$request->get('article_id'))->first();
        if(empty($articles)&&$request->get('article_id')!=0){
           return $this->failed("文章不存在");
        }
        $message->article_id=$request->get('article_id');
        $message->message=$request->get('message');
        $message->ip=$request->get('ip');
        $message->address=$request->get('address');
        $message->save();
        $message->reply=[];
        // 在数据库中查找用户信息
        $message->user= User::find($userAuth->user_id);
        return $this->success($message);


    }
    public function touristAdd(MessageRequest $request){
         return $this->failed("已关闭匿名留言！请登录",422);
        //  $message=new Message();
        // $tourist=$request->get('tourist');
        // if($request->has('qq')){
        //     $message->qq=$request->get('qq');
        // }
        // $message->tourist=$tourist;
        // $message->article_id=$request->get('article_id');
        // $message->message=$request->get('message');
        // $message->save();
        // return $this->message("留言成功");

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
    // 留言删除
    // 必填 id
    public function user_remove(MessageRequest $request){
        $id=$request->get('id');
        $message=Message::find($id);
         // return $this->message($message);
        $userAuth = Auth::guard('api')->user();
        $user=User::find($userAuth->user_id);
        if($message->user_id==$user->id||$user->is_admin==1){
             $boo=Message::find($id)->delete();
            return $this->message('留言删除成功！');
        }else{
            return $this->message('留言删除失败！');
        }

    }
    public function list(MessageRequest $request){

        $id=$request->input('id');
        $arr=[];
        if($id>=0){
            $arr=['article_id'=>$id];
            $articles=Article::where('id',$id)->first();
            if(empty($articles)&&$id>0){
               return $this->failed("留言不存在");
            }
        }else{
            $userAuth = Auth::guard('api')->user();
            $arr=['user_id'=>$userAuth->user_id];
        }
        $list=Message::where($arr)->with([
        'user' => function($query) {
            $query->select(['id','name','avatar_url',"is_admin"])->get();
        },
        'reply' => function($query) {
           // $query->select(['mess_id','reply','created_at'])->get();
            $query->with([
                'user' => function($query) {
                    $query->select(['id','name','avatar_url',"is_admin"])->get();
                },
                'messReply' => function($query) {
                    $query->with([
                        'user' => function($query) {
                            $query->select(['id','name'])->get();
                        }
                    ])->select(['id','user_id','reply'])->get();
                    // $query->select(['id','reply','mess_reply_id'])->get();
                }
            ])->select(['id','user_id','mess_id','reply','mess_reply_id','address','created_at'])->get();
        },
        ])->select(['id','user_id','tourist','qq','message','address','created_at'])
        ->orderBy('id','desc')
        ->paginate(20);
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
