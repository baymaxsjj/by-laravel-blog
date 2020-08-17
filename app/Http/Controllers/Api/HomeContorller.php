<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Home;
use App\Http\Requests\Api\HomeRequest;

class HomeContorller extends Controller
{
    // 待添加功能
    // 一个用户只能添加一次
    // 用户上传图片未进行保存
    // 可传入申请和为申请列表，0，1
    // 申请列表
    public function index(Request $request){
        $Home=Home::withTrashed()->orderBy('created_at','desc')->paginate(5);
        return $this->success($Home);

        // return $this->success($request->input('apply'));
    }
    public function list(Request $request){
        $show=['id','title','info','link','img_url'];
        $Homes=Home::get($show);
        return $this->success($Homes);
    }

    //user 申请添加友情链接
    public function add(HomeRequest $request){
        $Home=Home::create($request->all());
        return $this->message('添加成功');
    }
    //admin 添加友情链接
    //admin  移除友情链接
    public function remove(HomeRequest $request){
        $id=$request->input('id');
        $Home=Home::withTrashed()->find($id);
        if(is_null($Home->deleted_at)){
            $boo=Home::find($id)->delete();
            return $this->message('添加成功');
        }else{
            $boo=Home::withTrashed()->find($id)->restore();
            return $this->message('移除成功');
        }
    }
    public function update(HomeRequest $request){
        $id=$request->input('id');
        $Home=Home::find($id);
        $boo=$Home->update($request->all());
        if(!$boo){
            return $this->message('修改失败');
        }
        return $this->message('修改成功');
    }

}
