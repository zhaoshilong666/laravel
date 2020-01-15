<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LoginModel extends Model
{
    public $table = "login";
    protected $dateFormat = 'U';
    public $timestamps = false;
    protected $primaryKey = 'u_id';
    protected $guarded = [];





    public static function getLoginTime()
    {
        $logininfo=session('userinfo');
        $u_id=$logininfo->u_id;
        $login_time=Self::where(['u_id'=>$u_id])->value('login_time');

        return $login_time;
    }
    public static function updateLoginTime()
    {
        $logininfo=session('userinfo');
        $u_id=$logininfo->u_id;
        $login_time=Self::where(['u_id'=>$u_id])->update(['login_time'=>time()+10]);
    }



}
