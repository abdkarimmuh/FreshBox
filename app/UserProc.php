<?php

namespace App;

use App\Model\Procurement\AssignProcurement;
use Illuminate\Database\Eloquent\Model;

class UserProc extends Model
{
    protected $table = 'user_proc';
    protected $fillable = ['user_id', 'bank_account', 'bank_id', 'saldo', 'bank_id', 'category_id', 'origin_id'];

    public function assign_proc()
    {
        return $this->hasMany(AssignProcurement::class);
    }

    public function User()
    {
        return $this->belongsTo(User::class);
    }
}
