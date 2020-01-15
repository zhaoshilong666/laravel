<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexController extends Common
{

    public function login()
    {
        $login_data=[
            'user_name'=>'yangwenjing',
            'password'=>'123456'
        ];
        $login_api_url='http://api.zhaoshilong.com/login';
        $api_result=$this->curlPost($login_api_url,$login_data);
        print_r($api_result);
        exit;
    }
}
