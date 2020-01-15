<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WeekController extends Controller
{
    public function add()
    {
        return view("/week/add");
    }

}
