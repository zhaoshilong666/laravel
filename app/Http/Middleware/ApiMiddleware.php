<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Redis;
use Closure;

class ApiMiddleware
{
    public $key="1904apill";
    public $iv="2312414324134411";
    public $app_maps=[

            '1904-1'=>'1904-1password',
            '1904-2'=>'1904-2password'

    ];
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
       $data=$request->post('data');
       //解密数据
        $decrypt_data=$this->AesDecrypt($data);
    //验证客户端的签名
        $check=$this->checkSign($decrypt_data);
        if($check['status'] !=200)
        {
            return response($check);
        }else{
            return $next($request);
        }


    }

        private function checkSign($decrypt_data)
        {
            $client_sign = request()->post('sign');
            ksort($decrypt_data);
            //判断appid是否存在
            if (isset($this->app_maps[$decrypt_data['app_id']])) {
                $json = json_encode($decrypt_data) . 'app_key=' . $this->app_maps[$decrypt_data['app_id']];

                if ($client_sign == md5($json)) {
                    if (Redis::sAdd('code_set', $decrypt_data['rand'] . $decrypt_data['time'])) {
                        return [
                            'status' => 200,
                            'msg' => 'success',
                            'data' => md5($json)
                        ];
                    }else{
                        return [
                            'status'=>7777,
                            'mag' =>'chong',
                            'data'=>[],
                        ];
                    }
                    } else {
                        return [
                            'status' => 8888,
                            'msg' => 'check sign fail~',
                            'data' => []
                        ];
                    }

                } else {
                    return [
                        'status' => 9999,
                        'msg' => 'check sign fail',
                        'data' => []
                    ];
                }

            }


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
}
