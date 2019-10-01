<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserProc extends Model
{
    protected $table = 'user_proc';
    protected $fillable = ['user_id','bank_account','bank_id','saldo'];
}
