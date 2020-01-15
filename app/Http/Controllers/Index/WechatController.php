<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoginModel;
use Illuminate\Support\Facades\Cache;
use Session;

class WechatController extends Common
{
    public function index(Request $request)
    {
        //微信接入
        $echostr=$request->input("echostr");
        if(!empty($echostr)){
                echo $echostr;die;
        }
        $xml=file_get_contents("php://input");

        $xmlObj=simplexml_load_string($xml);
        //是否关注
        if($xmlObj->MsgType == "event" && $xmlObj->Event == "subscribe")
        {
            //用户ID
            $openid=(string)$xmlObj->FromUserName;
//            var_dump($openid);
            $EventKey=(string)$xmlObj->EventKey;
            $EventKey=ltrim($EventKey,'qrscene_');
            if($EventKey)
            {

                Cache::put($EventKey,$openid,20);
                $this->responseText("正在扫码登录，请稍等",$xmlObj);

            }
        }
        //关注过
        if($xmlObj->MsgType == "event" && $xmlObj->Event == "SCAN")
        {
            //用户ID
            $openid=(string)$xmlObj->FromUserName;
//            var_dump($openid);
            $EventKey=(string)$xmlObj->EventKey;
            if($EventKey)
            {
                Cache::put($EventKey,$openid,20);
                $this->responseText("正在扫码登录，请稍等",$xmlObj);
            }
        }
    }
}
