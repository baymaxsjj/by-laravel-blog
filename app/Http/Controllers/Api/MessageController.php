<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    //留言添加
    public function add(Request $request){
        $userAuth = Auth::guard('api')->user();
        $content=$request->input('message');
        $message=new Message();
        // 是否是为文章留言
        $article_id=$request->has('article_id') ? $request->input('artlcle_id'):0;
        $message->article_id=$article_id;
        $message->message=$content;
        $message->user_id=$userAuth->id;
        $message->save();
        return $this->success('留言成功'. $content);
    }
    // 留言删除
    public function remove(Request $request){
        $id=$request->input('id');
        $boo=Message::findOrFail($id)->delete();
        if($boo){
            return $this->success('删除成功');
        }
        return $this->failed('删除失败,可能已经删除了！');
    }
}
