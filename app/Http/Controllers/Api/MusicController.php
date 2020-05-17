<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Music;
use App\Http\Requests\Api\MusicRequest;
class MusicController extends Controller
{
    //
    function list(){
        $data=['music_id','title','name','type'];
        $list=Music::all($data);
        return $this->success($list);
    }
    function add(MusicRequest $request){
        $music=Music::create($request->all());
        return $this->message('添加成功');
    }
    function remove(MusicRequest $request){
       $id=$request->get('id');
       $music=Music::withTrashed()->find($id);
       if(is_null($music->deleted_at)){
           $boo=Music::find($id)->delete();
           return $this->message('添加成功');
       }else{
           $boo=Music::withTrashed()->find($id)->restore();
           return $this->message('移除成功');
       }
    }
    public function update(MusicRequest $request){
        $id=$request->input('music_id');
        $music=Music::where('music_id',$id)->first();
        $boo=$music->update($request->all());
        if(!$boo){
            return $this->message('修改失败');
        }
        return $this->message('修改成功');
    }

    function alist(){
        $music=Music::withTrashed()->orderBy('created_at','desc')->paginate(5);
        return $this->success($music);
    }
}
