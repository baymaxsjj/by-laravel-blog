<?php

namespace App\Http\Middleware\Api;

use Auth;
use Closure;
use App\Models\User;
class AdminLoginMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
         $user = User::whereName($request->name)->first();
         // echo($user);
       if (is_null($user)  || $user->is_admin != 1)
           return response()->json(
               [
                   'status' => 'error',
                   'code' => 403,
                   'message' => '你不是管理员，不能登录'
               ], 403
           );
       return $next($request);
    }
}
