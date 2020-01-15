<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User_weekModel;

class AdminController extends Controller
{
















   public function admin()
   {
        return view("/week/week");
   }
    public function update()
    {
        $info=User_weekModel::get();
        return view("/week/update",["data"=>$info]);
    }
        public function update_add(Request $request)
    {

       $w_id=$request->input("w_id");
       $res=User_weekModel::where(['w_id'=>$w_id])->first();
       $res->number=0;
       $res->save();
    }



}
