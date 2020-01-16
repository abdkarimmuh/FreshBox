<?php

namespace App\Model\FinanceAP;

use App\Model\MasterData\Warehouse;
use App\MyModel;
use App\Traits\SearchTraits;
use App\User;

class SettlementFinance extends MyModel
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

    public function getTotalAttribute()
    {
        $total = 0;
        foreach ($this->detail as $detail) {
            $total += $detail->total;
        }
        return $total;
    }

    public function scopeCash($q)
    {
        return $q->where('request_type', 1);
    }

    public function scopeAdvance($q)
    {
        return $q->where('request_type', 2);
    }
}
