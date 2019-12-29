<?php

namespace App\Model\FinanceAP;

use Illuminate\Database\Eloquent\Model;

class RequestFinanceDetail extends Model
{
    protected $table = 'finance_request_detail';

    public function getTotalAttribute()
    {
        return $this->price * $this->qty;
    }
}
