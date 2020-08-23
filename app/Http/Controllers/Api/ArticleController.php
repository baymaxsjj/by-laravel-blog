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
        $labelArr=explode(",",$request->get('label'));
        $lab=Label::where('article_id',$id)->get(['id','label']);
         $count1=count($lab);
         $count2=count($labelArr);
         if($count1==$count2){
             for($i=0;$i<$count1;$i++){
                if($lab[$i]->label!=$labelArr[$i]){
                    // 更新
                    $article=Label::where('id',$lab[$i]->id)->update(['label'=>$labelArr[$i]]);
                }
             }
         }else if($count1<$count2){
            for($i=0;$i<$count1;$i++){
               if($lab[$i]->label!=$labelArr[$i]){
                   // 更新
                   $article=Label::where('id',$lab[$i]->id)->update(['label'=>$labelArr[$i]]);
               }
            }
            for($count1;$count1<$count2;$count1++){
                $labels=DB::table('labels')->insert([
                    'label'=>$labelArr[$count1],
                    'article_id'=>$id
                ]);
            }
         }else{
            for($i=0;$i<$count1;$i++){
                if($i<$count2){
                    if($lab[$i]->label!=$labelArr[$i]){
                        // 更新
                        $article=Label::where('id',$lab[$i]->id)->update(['label'=>$labelArr[$i]]);
                    }
                }else{
                    Label::withTrashed()->find($lab[$i]->id)->delete();
                }

            }
         }

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
            ->withCount('message')
            ->paginate(6,['articles.id','articles.title','articles.desc','articles.img','articles.click','articles.classty','articles.like','articles.deleted_at','articles.created_at','articles.updated_at']);
        }else if($request->has('class')){
            $articles = Article::where('classty','=',$request->input('class'))->withCount('message')->orderBy('created_at', 'desc')->paginate(6, $show);
        }else if($request->has('search')){
            $type=$request->get('search');
            $articles=Article::where('title','like',"%$type%")->withCount('message')->orderBy('created_at', 'desc')->paginate(6, $show);
        }else{
            $articles = Article::withCount('message')->orderBy('created_at', 'desc')->paginate(6, $show);
        }
        foreach($articles as $item){
            $label=Label::where('article_id',$item->id)->get()->toArray();
            $item->label = array_values(array_unique(array_column($label, 'label')));
            $content=Article::findOrFail($item->id);
            $like=$content->visits()->count();
            $item->clicks = $like;
            // ->visits()->count()
        }

        return  $this->success($articles);
    }
    /**
     * U    文章内容
     */
       public function content(ArticleRequest $request){
        $id=$request->get('id');
        $content=Article::find($id);
         if (empty($content)){
             return $this->failed('该文章已经下架');
         }
         $label=Label::where('article_id',$id)->get()->toArray();
         $content->label = array_values(array_unique(array_column($label, 'label')));
          // 访问统计
         $content->visits()->increment();
          // visits($content)->increment();
         $content->view_count = $content->visits()->count();
         $prevId = Article::where('id', '<', $id)->max('id');
         $nextId = Article::where('id', '>', $id)->min('id');
         if(empty($prevId)){
             $id=Article::orderBy('id', 'desc')->first('id');
             $prevId =$id->id;
         }
         if(empty($nextId)){
             $id=Article::orderBy('id', 'asc')->first('id');
             $nextId =$id->id;
         }
         // 上一篇和下一篇文章
         $content->prevArticle = Article::where('id', $prevId)->get(['id', 'title']);
         $content->nextrAticle = Article::where('id', $nextId)->get(['id', 'title']);
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
    // 文章信息
    public function info(){
            $count=Article::count();
            return $this->success($count);
    }
    // 点赞
    public function click(ArticleRequest $request){
        $id=$request->input('id');
        $click=Article::where('id',$id)->first('click');
        $cont=Article::where('id',$id)->update(['click'=>$click->click+1]);
        return  $this->success($cont);
    }
    // 添加图片
    public function pictures(Request $request){
        header('Content-type: application/json');
        $type=$request->input('type');
        $url_path = 'uploads/cover';
       //获取原始文件名
       $file=$request->file('file');
       $name=$file->getClientOriginalName();
       //获取文件后缀名
       $hzm = $file->getClientOriginalExtension();
       $mime=$file->getClientMimeType();
       // $size=$file->getClientSize();
       //设置新文件名
       $newfile = md5($file);
       // 允许上传的图片后缀
       $allowedExts = array("gif", "jpeg", "jpg", "png");
       $temp = explode(".", $file);
       $extension = end($temp);
       if ((($mime == "image/gif")
       || ($mime == "image/jpeg")
       || ($mime == "image/jpg")
       || ($mime == "image/pjpeg")
       || ($mime == "image/x-png")
       || ($mime == "image/png"))
       // && ($size< 2048000)   // 小于 2000 kb
       && in_array( $hzm, $allowedExts))
       {
           //上传失败
           if ($file->isValid()==false)
           {
               $result = array(
                   "code" => 404,
                   "msg" => "上传失败"
               );
           }
           else
           {
                $newName = md5(date("Y-m-d H:i:s") . $name) . "." . $hzm;
                 $path = $file->move($url_path, $newName);
                 $namePath = $url_path . '/' . $newName;

               // //完整的上传路径
               $upload_filepath =base_path().'/public/'.$namePath;
                // echo $upload_filepath;
               //初始化CURL，上传到远程服务器
               $ch = curl_init();
               $url='';
               $imgType='';
                switch($type){
                    case 'baidu':
                        $url='http://bit.baidu.com/upload/fileUpload';
                        $imgType='file';
                        break;
                    case 'bilibili':
                        $url='https://service.bilibili.com/v2/chat/webchat/fileUploadForPostMsgBypc.action';
                        $imgType='file';
                        break;
                    case 'sina':
                        $url='https://iask.sina.com.cn/question/ajax/fileupload';
                        $imgType='wenwoImage';
                        break;
                    case 'souhu':
                        $url='https://v1.alapi.cn/api/image?type=Souhu';
                        $imgType='image';
                        break;
                    case 'tencent':
                        $url='https://om.qq.com/image/orginalupload';
                        $imgType='Filedata';
                        break;
                    case 'toutiao':
                        $url='http://mp.toutiao.com/upload_photo/?type=json';
                        $imgType='photo';
                        break;
                    case 'wangyi':
                        $url='http://you.163.com/xhr/file/upload.json';
                        $imgType='file';
                        break;
                    case 'wukong':
                        $url='https://www.wukong.com/wenda/web/upload/photo/';
                        $imgType='upfile';
                        break;
                    case 'xiaomi':
                        $url='https://qiye.mi.com/index/upload';
                        $imgType='uploadImg';
                        break;
                    case 'zol':
                        $url='http://my.zol.com.cn/index.php?c=Ajax_User&a=uploadImg';
                        $imgType='myPhoto';
                        break;
                    default:
                        $url='http://mp.toutiao.com/upload_photo/?type=json';
                        $imgType='photo';

                }
               //目标服务器地址
               curl_setopt($ch, CURLOPT_URL, $url);

               //设置上传的文件
               curl_setopt($ch, CURLOPT_POST, true);
               $data = array($imgType => new \CURLFile($upload_filepath));
               curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
               // 对认证证书来源的检查
               curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
               // 从证书中检查SSL加密算法是否存在
               curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
               //获取的信息以文件流的形式返回，而不是直接输出
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

               //发起请求
               $uploadimg = curl_exec($ch);

               //解析JSON
               $arr_result = json_decode($uploadimg, true);
               $imgurl ='';
                switch($type){
                    case 'baidu':
                        $img_data = $arr_result["data"];
                        $imgurl = "https://bit-images.bj.bcebos.com/bit-new/".$img_data;
                        break;
                    case 'bilibili':
                        $imgurl = $arr_result["url"];
                        break;
                    case 'sina':
                        $id = $arr_result["id"];
                        $imgurl = "http://pic.iask.cn/fimg/".$id.".jpg";
                        break;
                    case 'souhu':
                        $imgurl = $arr_result["data"]["url"]["Souhu"];
                        break;
                    case 'tencent':
                        $imgurl = $arr_result["data"]["url"];
                        break;
                    case 'toutiao':
                        $imgurl = $arr_result["web_url"];
                        break;
                    case 'wangyi':
                        $imgurl = $arr_result["data"][0];
                        break;
                    case 'wukong':
                        $imgurl = $arr_result["url"];
                        break;
                    case 'xiaomi':
                         $imgurl = $arr_result["data"]["key"];
                        break;
                    case 'zol':
                        $imgurl = $arr_result["url"];
                        break;
                    default:
                        $imgurl = $arr_result["web_url"];
                }
               //关闭请求
               curl_close($ch);
               $result = array(
                   "msg" => "上传成功",
                   "path" => $imgurl
               );

               //删除临时文件
               unlink($upload_filepath);
           }
       }
       else
       {
           // //格式不对
           // $result = array(
           //     "code" => 403,
           //     "msg" => "格式不符合规则"
           // );
           return  $this->failed('格式不符合规则');
       }

       //输出json
       return  $this->success($result);
    }
}
