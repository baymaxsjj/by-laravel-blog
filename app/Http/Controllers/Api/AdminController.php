<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
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
                    'name'=>$request->name,
                    'password'=>$request->password
                ]
            );
            if($token) {
                // Auth::guard('api')->logout();
                // 而 Auth::guard ('API')->user () 能拿到用户，说明你本身是 API 的请求，所以 Auth::user () 是拿不到 API 请求下的用户的，除非你指定默认 guard 为 ap
                // 返回当前用户
                $userAuth = Auth::guard('api')->user();
                // 在数据库中查找用户信息
                $user = User::find($userAuth->id);
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
        $data=['name','phone','email','avatar_url','updated_at'];
        $user = User::select($data)->find($userAuth->id);
        return $this->success($user);
    }
    /**
     * U    用户信息更新
     */
    public function update(UserRequest $request){
        $userAuth = Auth::guard('api')->user();
        $user = DB::table('users')->where('id',$userAuth->id)->first();
        if(Hash::check($request->get('password'),$user->password)){
            $pass=$request->get('pass');
            $info=$request->all();
            if(is_null($pass)){
                unset($info['password']);
            }else{
                $info['password']=$info['pass'];
                unset($info['pass']);
            }
            $use = User::find($userAuth->id);
            $use->update($info);
            return $this->message('修改成功');
        }else{
            return $this->message('密码不正确');
        }
    }

}
