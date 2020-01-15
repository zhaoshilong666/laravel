<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LoginModel;
use Illuminate\Support\Facades\Cache;

class Common extends Controller
{
    public $key="1904apill";
    public $iv="2312414324134411";

    const  appid='wx286c777a3a3abf79';
    const  appsecret='4aae80b37fc409e4203787d2faf5e58b';
    protected function AesEncrypt($data)
    {
        if(is_array($data))
        {
            $data=json_encode($data);
        }
        $encrypt=openssl_encrypt(
            $data,
            'AES-256-CBC',
            $this->key,
            1,
            $this->iv

        );
        return base64_encode($encrypt);
    }
    protected function AesDecrypt($encrypt)
    {
        $decrypt=openssl_decrypt(
            base64_decode($encrypt),
            'AES-256-CBC',
            $this->key,
            1,
            $this->iv
        );
        return json_decode($decrypt,true);
    }

    //客户需要把appid和appkey传递到服务器进行验证
    public function getAppIdAndKey()
    {

        return [
            'app_id'=>'1904-1',
            'app_key'=>'1904-1password'
        ];
    }

    private function _createSign($data,$app_key)
    {
        ksort($data);
        $json_str=json_encode($data);
        return md5($json_str.'app_key='.$app_key);
    }


    protected function curlPost($api_url,array $data,$is_post =1)
    {
        $ch=curl_init();
        $app_safe=$this->getAppIdAndKey();
        $data['app_id']=$app_safe['app_id'];

        //客户添加时间戳和随机数防止重放
        $data['rand']=rand(100000,999999);
        $data['time']=time();

        $all_data=[
            'data'=>$this->AesEncrypt($data),
            'sign'=>$this->_createSign($data,$app_safe['app_key'])
        ];
        if($is_post){
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$all_data);
        }else{
            $api_url=$api_url."?".http_build_query($data);
        }
        curl_setopt($ch,CURLOPT_URL,$api_url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $data=curl_exec($ch);
        curl_close($ch);
        return $data;
    }

    //get token
    public static function getToken()
    {
        //缓存里有数据 直接读取
        $access_token=Cache::get("access_token");
        if(empty($access_token))
        {
            //缓存中没有数据 调用接口获取
            $url="https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".Self::appid."&secret=".Self::appsecret;
            $data=file_get_contents($url);
            $data=json_decode($data,true);
            $access_token=$data['access_token'];
            //存储2小时
            Cache::put("access_token",$access_token,7200);
        }
        return $access_token;
    }
    public static function Post($url,$postData)
    {
        //初始化： curl_init
        $ch = curl_init();
        //设置	curl_setopt
        curl_setopt($ch, CURLOPT_URL, $url);  //请求地址
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); //返回数据格式
        curl_setopt($ch, CURLOPT_POST, 1);//post提交方式
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        //访问https网站 关闭ssl验证
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE); // 对认证证书来源的检查
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE); // 从证书中检查SSL加密算法是否存在
        //执行  curl_exec
        $result = curl_exec($ch);
        //关闭（释放）  curl_close
        curl_close($ch);
        return $result;
    }
    //回复文本
    public static function responseText($msg,$xmlObj)
    {
        echo "<xml>
                    <ToUserName><![CDATA[".$xmlObj->FromUserName."]]></ToUserName>
                    <FromUserName><![CDATA[".$xmlObj->ToUserName."]]></FromUserName>
                    <CreateTime>".time()."</CreateTime>
                    <MsgType><![CDATA[text]]></MsgType>
                    <Content><![CDATA[".$msg."]]></Content>
                    </xml>";die;
    }

}
