<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\SysMess;
use App\Http\Requests\Api\SysMessRequest;

class SysMessContorller extends Controller
{
    // 待添加功能
    // 一个用户只能添加一次
    // 用户上传图片未进行保存
    // 可传入申请和为申请列表，0，1
    // 申请列表
    public function index(Request $request){
        $SysMess=SysMess::withTrashed()->orderBy('created_at','desc')->paginate(5);
        return $this->success($SysMess);

        // return $this->success($request->input('apply'));
    }
    public function list(Request $request){
        $show=['id','title','content'];
        $SysMesss=SysMess::orderBy('id','desc')->first($show);
        return $this->success($SysMesss);
    }

    //user 申请添加友情链接
    public function add(SysMessRequest $request){
        $SysMess=SysMess::create($request->all());
        return $this->message('添加成功');
    }
    //admin 添加友情链接
    //admin  移除友情链接
    public function remove(SysMessRequest $request){
        $id=$request->input('id');
        $SysMess=SysMess::withTrashed()->find($id);
        if(is_null($SysMess->deleted_at)){
            $boo=SysMess::find($id)->delete();
            return $this->message('添加成功');
        }else{
            $boo=SysMess::withTrashed()->find($id)->restore();
            return $this->message('移除成功');
        }
    }
    public function update(SysMessRequest $request){
        $id=$request->input('id');
        $SysMess=SysMess::find($id);
        $boo=$SysMess->update($request->all());
        if(!$boo){
            return $this->message('修改失败');
        }
        return $this->message('修改成功');
    }

}
