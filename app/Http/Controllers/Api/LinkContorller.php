<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Link;
use App\Http\Requests\Api\LinkRequest;

class LinkContorller extends Controller
{
    // 待添加功能
    // 一个用户只能添加一次
    // 用户上传图片未进行保存
    // 可传入申请和为申请列表，0，1
    // 申请列表
    public function index(Request $request){
        $link=Link::withTrashed()->orderBy('created_at','desc')->paginate(5);
        return $this->success($link);

        // return $this->success($request->input('apply'));
    }
    public function list(LinkRequest $request){
        $show=['name','info','link','imgUrl'];
        $type=$request->get('type');
        $links=Link::where(['type'=>$type])->get($show);
        return $this->success($links);
    }

    //user 申请添加友情链接
    public function add(LinkRequest $request){
        $link=Link::create($request->all());
        return $this->message('添加成功');
    }
    //admin 添加友情链接
    //admin  移除友情链接
    public function remove(LinkRequest $request){
        $id=$request->input('id');
        $link=Link::withTrashed()->find($id);
        if(is_null($link->deleted_at)){
            $boo=Link::find($id)->delete();
            return $this->message('添加成功');
        }else{
            $boo=Link::withTrashed()->find($id)->restore();
            return $this->message('移除成功');
        }
    }
    public function update(LinkRequest $request){
        $id=$request->input('id');
        $link=Link::find($id);
        $boo=$link->update($request->all());
        if(!$boo){
            return $this->message('修改失败');
        }
        return $this->message('修改成功');
    }

}
