<?php

namespace App\Http\Controllers\Api;
use Mail;
use Illuminate\Http\Request;
use App\Http\Requests\Api\UserRequest;
use App\Models\User;
use App\Models\UserAuth;
use App\Models\Message;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;
use App\Mail\Welcome;
use Socialite;
class UserController extends Controller
{
// 登录
  public function login(UserRequest $request){
    //   attempt 方法会接受一个键值对数组作为其第一个参数。这个数组的值将用来在数据库表中查找用户
    // 传递给 guard 方法的看守器名称应该与 auth.php 配置文件中 guards 中的其中一个值相对应：
    // 我们可以通过 Auth facade 来访问 Laravel 的认证服务，因此需要确认类的顶部引入了 Auth facade
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
  //退出登录
  public function logout(){
	if(Auth::guard('api')->user()){
		Auth::guard('api')->logout();
	}		
    return $this->message('退出登录成功！');
  }
//   注册
  public function sign(UserRequest $request){
        $arr=explode('@',$request->get('email'));
        if($arr[1]=='qq.com'){
            $request['avatar_url']='https://q1.qlogo.cn/g?b=qq&nk='.$arr[0 ].'&s=100';
        }else{
           $request['avatar_url']="https://avatars.dicebear.com/v2/identicon/:seed.svg";
        }
        $user=User::create($request->all());
        $emailIdentifier = [
            'user_id' => $user->id,
            'login_type' => 'email',
            'login_name' => $request->email,
            'password' => $request->password
        ];
        $nameIdentifier = [
            'user_id' => $user->id,
            'login_type' => 'name',
            'login_name' => $request->name,
            'password' => $request->password
        ];
        UserAuth::create($emailIdentifier);
        UserAuth::create($nameIdentifier);
        // Mail::to($user)->send(new Welcome($user));
        return $this->message("注册成功");
  }
// 获取个人信息 userInfo()
  public function userinfo(){
    //   返回当前用户
      $userAuth = Auth::guard('api')->user();
      // 在数据库中查找用户信息
      $user = User::find($userAuth->user_id);
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
            UserAuth::where('user_id',$id)->delete();
            Message::where('user_id',$id)->delete();
            Reply::where('user_id',$id)->delete();
            return $this->message('冻结成功');
        }else{
            User::withTrashed()->find($id)->restore();
            UserAuth::withTrashed()->where('user_id',$id)->restore();
            Message::withTrashed()->where('user_id',$id)->restore();
            Reply::withTrashed()->where('user_id',$id)->restore();
            return $this->message('解冻成功');
        }
  }
 // 获取用户列表
    public function list(){
        $users = User::withTrashed()->where('is_admin',0)->paginate(5);
        return $this->success($users);
    }
     /**
     * 将用户重定向到party认证页面
     *
     * @return Response
     */
    public function redirectToProvider($party)
    {
        // dd($party);
        return Socialite::driver($party)->redirect();
    }

    /**
     * 从party获取用户信息.
     *
     * @return Response
     */
    public function handleProviderCallback($party)
    {
        $partyUser= Socialite::driver($party)->stateless()->user();
        $usrlogin=UserAuth::withTrashed()->where(['login_name' => $partyUser->id,'login_type' => $party])->first();
        if(!empty($usrlogin->deleted_at)){
            return '账户违规！禁止登录.若有问题请联系博主！';
        }
        //  // 邮件存在则不创建，共享一个账号数据
        $partyRandom="_".$party."_".\Str::random(4);
        $pattern = '/^(http):\/\//i';
        $replacement = 'https://';
        $avatar= preg_replace($pattern, $replacement, $partyUser->avatar);
        $user = [
            'email' => $partyUser->email,
            'name' => $partyUser->nickname.$partyRandom,
            'avatar_url' => $avatar,
            'password' => bcrypt(\Str::random(16))
        ];
        $isUser=User::where(['email' => $user['email']])->first();
        $newUser='';
        // 判断邮箱是否为空
        if(empty($isUser->email)){
            //判断该账号是否存在
            $auth=UserAuth::where(['login_type' => $party,'login_name' => $partyUser->id])->first();
            if(empty($auth)){
                //不存在就创建
                $newUser = User::create($user);
            }else{
                //存在就返回个人信息
                $newUser=User::find($auth->user_id);
            }
        }else{
            //不为空，就合并账号
            $newUser = User::firstOrCreate(['email' => $user['email']], $user);
        }
        // 创建一条party账号
        $partyIdentifier = [
            'user_id' => $newUser->id,
            'login_type' => $party,
            'login_name' => $partyUser->id,
            'password' => bcrypt(\Str::random(16))
        ];
        UserAuth::updateOrCreate([
            'login_name' => $partyUser->id,
            'login_type' => $party
        ], $partyIdentifier);

        // $token = Auth::guard('api')->tokenById($newUser->id);
        $token=Auth::guard('api')->attempt(
            [
                'login_type' => $party,
                'login_name' => $partyUser->id,
                'password' => $partyIdentifier['password']
            ]
        );

        return view('partyLogin')->with(['token' =>'bearer '.$token, 'url' => env('LOGIN_REDIRECT').'/login']);
        // dd($user);
    }
}
