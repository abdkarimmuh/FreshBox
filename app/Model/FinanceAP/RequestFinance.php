<?php

namespace App\Model\FinanceAP;

use App\Model\MasterData\Warehouse;
use Illuminate\Database\Eloquent\Model;

class RequestFinance extends Model
{
    protected $table = 'finance_request';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'master_warehouse_id');
    }
}
