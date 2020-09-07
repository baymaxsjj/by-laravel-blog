<?php

namespace App\Http\Controllers\Api;

use Mail;
use App\Mail\Validate;
use App\Models\User;
use App\Models\UserAuth;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Http\Requests\Api\EmailRequest;
use Illuminate\Support\Facades\Redis;

class ValidateController extends Controller
{
    //
     // 生成验证码
        public function generate_captcha()
        {
            return rand(1000, 9999);
        }

        // 发送邮件
        public function send_email(EmailRequest $request){
            $user = User::whereEmail($request->email)->first();

            if ($this->is_robot($user->id, 60))
                return $this->failed('操作太频繁，稍后再试', 200);

            // 验证码，同时错误次数归0
            $user->captcha = $this->generate_captcha();
            Redis::setex('captcha:'.$user->id, 300, $user->captcha);
            Redis::del('checkCount:'.$user['id']);

            $this->update_robot_time($user->id);

            Mail::to($user)->send(new Validate($user));
            return $this->message('邮件发送成功');
            // return $this->success($user);
        }

        // 校验验证码,设置新密码
        public function forget(EmailRequest $request){
            $user = User::whereEmail($request->email)->first();
            $RedisCap = Redis::get('captcha:'.$user['id']);
            $checkCount = Redis::get('checkCount:'.$user['id']);
            if (!$RedisCap)
                return $this->failed('请先获取验证码', 200);

            if ($checkCount > 5)
                return $this->failed('错误次数太多，请重新获取验证码', 200);

            if ($request->captcha != $RedisCap){
                Redis::incr('checkCount:'.$user['id']);
                return $this->failed('验证码不正确', 200);
            }
            $user->update(['password' => $request->password]);
            $users=UserAuth::where(['user_id'=>$user->id])->where(function($query){
                $query->where('login_type','name')
                      ->orWhere(function($query){
                          $query->where('login_type','email');
                      });
            })->get();
            foreach($users as $item) {
                $item->update(['password'=>$request->password]);
            }
            Redis::del('captcha:'.$user['id']);
            return $this->message('新密码设置成功');
        }

        // 检查是否机器人
        public function is_robot($id, $time = 10){
            // 如果没有last_action_time说明接口没被调用过
            $lastActionTime = Redis::get('lastActionTime:'.$id);
            if (!$lastActionTime)
                return false;

            $elapsed = time() - $lastActionTime;
            return !($elapsed > $time);
        }

            // 上一次操作时间
            public function update_robot_time($id){
                Redis::set('lastActionTime:'.$id, time());
            }
}
