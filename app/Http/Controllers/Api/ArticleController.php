<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\ArticleRequest;
use App\Models\Article;
use App\Models\Label;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
class ArticleController extends Controller
{
    /**
     * A    添加文章
     */
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
    public function update(ArticleRequest $request){
        $id=$request->input('id');
        unset($request['id']);
        unset($request['label']);
        $article=Article::where('id',$id)->update($request->all());
        return $this->message('文章修改成功');
    }
    /**
     *  U   文章类别列表
     */
    public function class(){
        $class=Article::distinct()->get(['classty']);
        return $this->success($class);
    }
    /**
     *  U   搜索文章
     */
    public function search(ArticleRequest $request){
        $search=$request->input("search");
        $articles=Article::where('title',$search)->orWhere('title','like','%'.$search.'%')->take(5)->get(['id','title']);
        return  $this->success($articles);
    }
    /**
     *  U   文章列表
     */
    public function list(ArticleRequest $request){
        $show=['id','title','desc','img','click','classty','like','deleted_at','created_at','updated_at'];
        $type='';
        if($request->has('label')){
            $label=$request->input('label');
            $articles=Article::
            leftJoin('labels','articles.id','=','labels.article_id')
            ->where('label',$label)
            ->paginate(6,['articles.id','articles.title','articles.desc','articles.img','articles.click','articles.classty','articles.like','articles.deleted_at','articles.created_at','articles.updated_at']);
        }else if($request->has('class')){
            $articles = Article::where('classty','=',$request->input('class'))->orderBy('created_at', 'desc')->paginate(6, $show);
        }else if($request->has('search')){
            $type=$request->get('search');
            $articles=Article::where('title','like',"%$type%")->orderBy('created_at', 'desc')->paginate(6, $show);
        }else{
            $articles = Article::orderBy('created_at', 'desc')->paginate(6, $show);
        }
        foreach($articles as $item){
            $label=Label::where('article_id',$item->id)->get()->toArray();
            $item->label = array_values(array_unique(array_column($label, 'label')));
        }
        return  $this->success($articles);
    }
    /**
     * U    文章内容
     */
    public function content(ArticleRequest $request){

        $content=Article::findOrFail($request->get('id'));
        $label=Label::where('article_id',$request->get('id'))->get()->toArray();
        $content->label = array_values(array_unique(array_column($label, 'label')));
         // 访问统计
        $content->visits()->increment();
         // visits($content)->increment();
         $content->view_count = $content->visits()->count();
        return $this->success( $content);
    }
    /**
     * A   文章删除
     */
    public function remove(ArticleRequest $request){
            $id=$request->get('id');
            $article=Article::withTrashed()->find($id);
            if($article->deleted_at==1){
                $boo=Article::withTrashed()->find($id)->delete();
                $label=Label::withTrashed()->where('article_id',$id)->select('id')->get();
                foreach($label as $i){
                    Label::withTrashed()->find($i->id)->delete();
                }
                return $this->message('下架成功');
            }else{
                $boo=Article::withTrashed()->find($id)->restore();
                $label=Label::withTrashed()->where('article_id',$id)->select('id')->get();
                foreach($label as $i){
                    Label::withTrashed()->find($i->id)->restore();
                }
                return $this->message('上架成功');
            }
    }

    /**
     * A    文章列表
     */
    public function alist(Request $request){
        $show=['id','title','desc','img','click','classty','like','deleted_at','created_at','updated_at'];
        $articles=Article::withTrashed()->with(['label' => function($query) {
            $query->select(['id','label','article_id'])->get();
        },
        ])->select($show)
        ->orderBy('id','desc')
        ->paginate(10);
        return  $this->success($articles);
    }
    public function info(){
            $count=Article::count();
            return $this->success($count);
    }
}
