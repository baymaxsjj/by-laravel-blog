<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
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
    // 获取用户列表
    public function userlist(){
        $users = User::where('is_admin',0)->paginate(5);
        return $this->success($users);
    }
}
