<?php

namespace App\Http\Middleware\Api;

use Auth;
use Closure;
use App\Models\User;
class AdminMiddleware
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
        $userAuth = Auth::guard('api')->user();
        // dd($userAuth);
        $user = User::find($userAuth->user_id);

        if ($user->is_admin != 1)
            return response()->json(
                [
                    'status' => 'error',
                    'code' => 403,
                    'message' => '你没有权限操作'
                ], 403
            );

        return $next($request);
    }
}
