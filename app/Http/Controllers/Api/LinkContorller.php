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
    public function index(Request $request){
       
        if(empty($request->has('apply'))){
            $link=Link::paginate(5);
            return $this->success($link);
        }else{
            $link=link::where('apply',$request->input('apply'))->paginate(5);;
            return $this->success($link);
        }
        // return $this->success($request->input('apply'));
        
    }
    //user 申请添加友情链接
    public function apply(LinkRequest $request){
        $link=new Link();
        $link->name=$request->input('name');
        $link->link=$request->input('link');
        $link->info=$request->input('info');
        $link->imgUrl=$request->input('imgUrl');
        $boo=$link->save();
        if(!$boo){
            return $this->failed('申请失败');
        }
        return $this->success('申请成功,等待管理员添加');

    }
    //admin 添加友情链接
    public function add(LinkRequest $request){
        $id=$request->input('id');
        
        $link=Link::find($id);
        $boo=$link->update(['apply'=>1]);
        if(!$boo){
            return $this->failed('添加失败');
        }
        return $this->success('添加成功');
    }
    //admin  移除友情链接
    public function remove(LinkRequest $request){
        $id=$request->input('id');
        
        $link=Link::find($id);
        $boo=$link->update(['apply'=>0]);
        if(!$boo){
            return $this->failed('移除失败');
        }
        return $this->success('移除成功');
    }
    public function update(LinkRequest $request){
        $id=$request->input('id');
        $link=Link::find($id);
        $boo=$link->update($request->all());
        if(!$boo){
            return $this->failed('修改失败');
        }
        return $this->success('修改成功');
    }

}
