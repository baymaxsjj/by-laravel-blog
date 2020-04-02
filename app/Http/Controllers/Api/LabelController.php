<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\LabelRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Label;

class LabelController extends Controller
{
    //
    public function add(LabelRequest $request){
        $userAuth = Auth::guard('api')->user();
        $label=$request->input('label');
        $la=new Label();
        $la->label=$label;
        $la->user_id=$userAuth->id;
        $la->save();
        return $this->success('添加成功');
    }
    public function remove(LabelRequest $request){
        $id=$request->input('id');
        $boo=Label::findOrFail($id)->delete();
        if($boo){
            return $this->success('删除成功');
        }
        return $this->failed('删除失败,可能已经删除了！');
    }
}
