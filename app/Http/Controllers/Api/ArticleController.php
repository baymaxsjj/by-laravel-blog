<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\ArticleRequest;
use App\Models\Article;
use App\Models\Label;
use App\Models\User;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class ArticleController extends Controller
{
    //
    public function add(ArticleRequest $request){
        $userAuth = Auth::guard('api')->user();
        // 在数据库中查找用户信息
        $user = User::find($userAuth->id);
        $request['name']=$user->name;
        $article=Article::create($request->all());
        if($request->get('label')){
            $labelArr=explode(",",$request->get('label'));
            foreach($labelArr as $label){
                $labels=DB::table('labels')->insert([
                    'label'=>$label,
                    'article_id'=>$article->id
                ]);
            }
        }
        return $this->message('文章发表成功');
    }
    public function list(Request $request){
        $show=['id','title','desc','img','click','classty','like','deleted_at','created_at','updated_at'];
        if(empty($request->input('label'))){
            $articles = Article::orderBy('created_at', 'desc')->paginate(4, $show);
        }else{
            $label=$request->input('label');
            $articles=DB::table('articles')
            ->join('labels','articles.id','=','labels.article_id')
            ->where('label',$label)
            ->paginate(4);
        }
        foreach($articles as $item){
            $label=Label::where('article_id',$item->id)->get()->toArray();
            $item->label = array_values(array_unique(array_column($label, 'label')));
        }
        return  $this->success($articles);

    }
    public function content(ArticleRequest $request){
        try{
            $content=Article::findOrFail($request->input('id'));
            return $this->success($content);
        }catch(Exception $e){
            return $this->failed('查询失败,文章不存在');
        }
    }
    public function remove(ArticleRequest $request){
            $id=$request->get('id');
            $article=Article::withTrashed()->find($id);
            if(empty($article->deleted_at)){
                $boo=Article::find($id)->delete();
                return $this->message('下架成功');
            }else{
                $boo=Article::withTrashed()->find($id)->restore();
                return $this->message('上架成功');
            }
    }
}
