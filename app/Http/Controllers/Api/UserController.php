<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Requests\Api\UserRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
// 登录
  public function login(UserRequest $request){
    //   attempt 方法会接受一个键值对数组作为其第一个参数。这个数组的值将用来在数据库表中查找用户
    // 传递给 guard 方法的看守器名称应该与 auth.php 配置文件中 guards 中的其中一个值相对应：
    // 我们可以通过 Auth facade 来访问 Laravel 的认证服务，因此需要确认类的顶部引入了 Auth facade
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
  //退出登录
  public function logout(){
    Auth::guard('api')->logout();
    return $this->success('退出登录成功');
  }
//   注册
  public function sign(UserRequest $request){
      $arr=explode('@',$request->get('email'));
      if($arr[1]=='qq.com'){
            $request['avatar_url']='http://q1.qlogo.cn/g?b=qq&nk='.$arr[0 ].'&s=100';
      }else{
           $request['avatar_url']="";
      }
    $user=User::create($request->all());
    return $this->message("注册成功");
  }
// 获取个人信息 userInfo()
  public function userinfo(){
    //   返回当前用户
      $userAuth = Auth::guard('api')->user();
      // 在数据库中查找用户信息
      $user = User::find($userAuth->id);
      return $this->success($user);
  }
  public function modify(UserRequest $request){
        if(!empty($request->has('name'))||!empty($request->has('is_admin'))){
            return $this->failed('权限不够',400);
        }
        $userAuth=Auth::guard('api')->user();
        $user=User::find($userAuth->id);
        $user->update($request->all());
        return $this->message('修改成功');
  }
  public function remove(UserRequest $request){
        $id=$request->get('id');
        $user=User::withTrashed()->find($id);
        if(empty($user->deleted_at)){
            $boo=User::find($id)->delete();
            return $this->message('冻结成功');
        }else{
            $boo=User::withTrashed()->find($id)->restore();
            return $this->message('解冻成功');
        }
  }
 // 获取用户列表
    public function list(){
        $users = User::withTrashed()->where('is_admin',0)->paginate(5);
        return $this->success($users);
    }
}
