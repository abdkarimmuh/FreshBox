<?php

namespace App\Model\FinanceAP;

use App\Model\MasterData\Warehouse;
use App\MyModel;
use App\Traits\SearchTraits;
use App\User;

class RequestFinance extends MyModel
{
    use SearchTraits;
    protected $table = 'finance_request';
    protected $dates = [
        'request_date',
        'request_confirm_date'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function warehouse()
    {
        return $this->belongsTo(Warehouse::class, 'master_warehouse_id');
    }

    public function detail()
    {
        return $this->hasMany(RequestFinanceDetail::class, 'request_finance_id', 'id');
    }
}
