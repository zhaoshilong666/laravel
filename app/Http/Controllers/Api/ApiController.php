<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User_weekModel;

class ApiController extends Controller
{
    public function login(Request $request)
    {
       dump($request->post());
       exit;
    }








































    public function update_do(Request $request)
    {
        header("Access-Control-Allow-Origin: *");
        $week_name=$request->input("week_name");
        $week_pwd=$request->input("week_pwd");

        $data=User_weekModel::where(["week_name"=>$week_name])->first();

        if($data['number']>=3)
        {
            return json_encode(["ret"=>203,"msg"=>"已锁定"]);die;
        }else{
            $data->week_pwd=$week_pwd;
            $data->number=$data['number']+1;
            $data->save();
        }

    }
    public $key="1904apill";
    public $iv="2312414324134411";
    public function ll()
    {

        $arr=[
            'name'=>"yangwenjing",
            'pwd'=>"12345678"
        ];
        echo $encrypt=$this->AesEncrypt($arr);
        echo "<hr/>";
        $decrypt=$this->AesDecrypt($encrypt);
        echo "<pre/>";
        print_r($decrypt);


    }


}
