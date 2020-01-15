<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoginModel;
use Illuminate\Support\Facades\Cache;
use Session;

class LoginController extends Common
{
    public function login()
    {
        return view("login/login");
    }
    public function add(Request $request){
        $data=$request->all();

        $info=LoginModel::where(['u_name'=>$data['u_name']])->first();

        if(empty($info)){
            return redirect("/login")->withErrors("用户不存在");
        }
        //判断当前用户是否锁定
        if(!empty($info->error_time) && time() <$info->error_time)
        {
          return redirect("/login")->withErrors("用户一锁定");
        }
        //判断用户登录错误次数
        if($data['u_pwd'] !=$info['u_pwd'])
        {
            $info->error_num=$info['error_num']+1;
            if($info->error_num>=3){
                $info->error_time=time() + 300;
                $info->error_num=0;
            }
            $info->save();


        }else{
            $info->error_num=0;
            $info['session_id'] = Session::getId();
            $request->session()->put('userinfo',$info);
            $info->login_time=time();
            $info->save();
            return redirect("/index");

        }

    }
    public function index(){
        echo 123;
    }

    public function wechat()
    {
        //带参数的二维码
        $access_token=$this->getToken();
        $status=md5(uniqid());

        $url="https://api.weixin.qq.com/cgi-bin/qrcode/create?access_token={$access_token}";
        $postData=[
            'expire_seconds'=> 60,
            'action_name'=>'QR_STR_SCENE',
             'action_info'=> [
                "scene"=> [
                'scene_str'=>$status
                    ],
                ],
            ];
        $postData=json_encode($postData,true);
        $res=$this->Post($url,$postData);
        $res=json_decode($res,true);
        $data="https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=".$res['ticket'];

        return view('login.wechat',['imgPath'=>$data,'status'=>$status]);
    }
    // 执行微信扫码登录
    public function do_wechatlogin(Request $request)
    {
        $all = $request->all();
        // dd($all);
        //查看缓存 如果缓存存在  则登录成功
        $openid = Cache::get($all);
        if(!$openid){
            return json_encode(['ret'=>0,'msg'=>"请先扫码在再操作"]);
        }else{
            $request->session()->put('userinfo',$info);
            return json_encode(['ret'=>1,'msg'=>"登录成功"]);
        }



    }
}
