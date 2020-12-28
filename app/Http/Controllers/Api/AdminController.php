<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\UserRequest;
use App\Models\User;
use App\Models\Message;
use App\Models\Reply;
use App\Models\Article;
use App\Models\UserAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
class AdminController extends Controller
{
    /**
     * A    管理员登录
     */
    public function login(UserRequest $request){
        $name=$request->input('name');
        $user=User::where('name',$name)->first();
        if($user->is_admin==1){
            $token=Auth::guard('api')->attempt(
                [
                    'login_type' => $request->type,
                    'login_name'=>$request->name,
                    'password'=>$request->password
                ]
            );
            if($token) {
                // Auth::guard('api')->logout();
                // 而 Auth::guard ('API')->user () 能拿到用户，说明你本身是 API 的请求，所以 Auth::user () 是拿不到 API 请求下的用户的，除非你指定默认 guard 为 ap
                // 返回当前用户
                $userAuth = Auth::guard('api')->user();
                // 在数据库中查找用户信息
                $user = User::find($userAuth->user_id);
                //时间不对更改时区 在/config/app.php 'timezone' => 'Asia/Shanghai',更新登录时间
                $user->update([$user->updated_at = time()]);
                // 返回token

                return $this->success(['token' => 'bearer '. $token]);
            }
            return $this->failed('账号或密码错误',400);
        }
        return $this->failed('非管理员账号',400);
    }
    /**
     * U    用户信息
     */
    public function info(){
        $userAuth = Auth::guard('api')->user();
        // 在数据库中查找用户信息$
        $data=['id','name','phone','email','avatar_url','is_admin','updated_at'];
        $user = User::select($data)->find($userAuth->user_id);
        return $this->success($user);
    }
    public function getBlogInfo(){
        $article=Article::count();
        $user=User::count();
        $message=Message::count();
        $browse=visits('App\Models\Article')->count();
        $messageStatis=Message::where('created_at','<', Carbon::now())->where('created_at','>', Carbon::today()->subDays(7))->select(
             DB::raw("COUNT(id) AS num"),
             DB::raw("DATE_FORMAT(created_at,'%Y/%m/%d') AS date")
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        $replyStatis=Reply::where('created_at','<', Carbon::now())->where('created_at','>', Carbon::today()->subDays(7))->select(
             DB::raw("COUNT(id) AS num"),
             DB::raw("DATE_FORMAT(created_at,'%Y/%m/%d') AS date")
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        $userStatis=User::where('created_at','<', Carbon::now())->where('created_at','>', Carbon::today()->subDays(7))->select(
             DB::raw("COUNT(id) AS num"),
             DB::raw("DATE_FORMAT(created_at,'%Y/%m/%d') AS date")
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();
        $articleStatis=Article::where('created_at','<', Carbon::now())->where('created_at','>', Carbon::today()->subDays(7))->select(
             DB::raw("COUNT(id) AS num"),
             DB::raw("DATE_FORMAT(created_at,'%Y/%m/%d') AS date")
        )
        ->groupBy('date')
        ->orderBy('date')
        ->get();
		$info=array('quantity'=>[
			"article"=>$article,
			"user"=>$user,
			"message"=>$message,
			"browse"=>$browse
		],'statistics'=>[
            "article"=>$articleStatis,
            "message"=>$messageStatis,
            "user"=>$userStatis,
            "reply"=>$replyStatis
         ]);
        return $this->success($info);
    }
    /**
     * U    用户信息更新
     */
    public function update(UserRequest $request){
        if($request->has('type')){
            if($request->has('name')){
                $userAuth = Auth::guard('api')->user();
                $user = User::find($userAuth->user_id);
                $user->update(['name'=>$request->get('name')]);
                UserAuth::where(['user_id'=>$user->id,'login_type'=>'name'])->update(['login_name'=>$request->get('name')]);
                return $this->message('名称修改成功');
            }else{
                return $this->message('名称不能为空');
            }
        }
        $userAuth = Auth::guard('api')->user();
        $user = User::find($userAuth->user_id);
        if(Hash::check($request->get('password'),$userAuth->password)){
            $pass=$request->get('pass');
            $name=$request->get('name');
            $info=$request->all();
            // 没有修改密码
            if(is_null($pass)){
                unset($info['password']);
            }else{
                $info['password']=$info['pass'];
                unset($info['pass']);
                $users=UserAuth::where(['user_id'=>$user->id])->where(function($query){
                    $query->where('login_type','name')
                          ->orWhere(function($query){
                              $query->where('login_type','email');
                    });
                })->get();
                foreach($users as $item) {
                    $item->update(['password'=>$pass]);
                }
            }
            if(!is_null($name)){
                UserAuth::where(['user_id'=>$user->id,'login_type'=>'name'])->update(['login_name'=>$name]);
            }
            $user->update($info);
            return $this->message('修改成功');
        }else{
            return $this->message('密码不正确');
        }
    }

}
