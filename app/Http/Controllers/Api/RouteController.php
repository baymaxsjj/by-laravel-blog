<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Route;
use App\Http\Requests\Api\RouteRequest;
class RouteController extends Controller
{
    //
    public function add(RouteRequest $request){
        $boo=Route::create($request->all());
        if($boo){
           return $this->message('添加成功');
        }
        return $this->message('添加失败');
    }
    public function remove(RouteRequest $request){
        $id=$request->get('id');
        $route=Route::withTrashed()->find($id);
        if( is_null($route->deleted_at)){
            $boo=Route::find($id)->delete();
            return $this->message('移除成功');
        }else{
            $boo=Route::withTrashed()->find($id)->restore();
            return $this->message('添加成功');
        }
    }
    public function update(RouteRequest $request){
        $id=$request->input('id');
        $route=Route::find($id);
        $boo=$route->update($request->all());
        if(!$boo){
            return $this->message('修改失败');
        }
        return $this->message('修改成功');
    }

    public function userList(){
        $list=Route::orderBy('data','desc')->get(['id','logo','data','content','category']);
        return $this->success($list);
    }
    // public function carousel(){
    //     // $list=Route::where('carousel','1' )->orderBy('data','desc')->paginate(5);
    //     $list=Route::where('is_carousel','1')->orderBy('data','desc')->paginate(5);
    //     return $this->success($list);
    // }
    public function list(){
        $list=Route::withTrashed()->orderBy('data','desc')->paginate(5);
        return $this->success($list);
    }
}
