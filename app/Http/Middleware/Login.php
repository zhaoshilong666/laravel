<?php

namespace App\Http\Middleware;

use Closure;
use Session;
use App\Models\LoginModel;

class Login
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
        $session_id = Session::getId();
        $u_id = session()->get('userinfo')['u_id'];
        $info = LoginModel::where('u_id',$u_id)->first();
        if($session_id!=$info['session_id'])
        {
            return redirect("/login")->withErrors("异地登录");

        }
        //判断十分钟未操作 重新登录
        if(time() >LoginModel::getLoginTime() + 10)
        {
            session()->forget('userinfo');
            return redirect("/login");
        }
        LoginModel::updateLoginTime();
        return $next($request);
    }
}
