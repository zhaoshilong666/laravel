<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User_weekModel extends Model
{

    public $table = "user_week";
    protected $dateFormat = 'U';
    public $timestamps = false;
    protected $primaryKey = 'w_id';
    protected $guarded = [];


}
