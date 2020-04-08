<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Route;
class RouteController extends Controller
{
    //
    public function add(RouteRequest $request){
        $boo=Route::create($request->all());
        if($boo){
           return $this->success('添加成功')
        }
        return $this->failed('添加失败',400)
    }
    public function remove(RouteRequest $request){
         $boo=Route::destroy($request->id);
         if($boo){
            return $this->success('删除成功')
         }
         return $this->failed('删除失败',400)
    }
    public function list(){
        $list=Route::orderBy('data','desc')->get();
        return $this->success($list);
    }
}
