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
    protected $fillable = ['status'];
    protected $dates = [
        'request_date',
        'request_confirm_date'
    ];

    protected $appends = ['status_html'];

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

    public function getStatusHtmlAttribute()
    {
        if ($this->status === 1) {
            return '<span class="badge badge-secondary">Submit</span>';
        } elseif ($this->status === 2) {
            return '<span class="badge badge-warning">Confirm</span>';
        } elseif ($this->status === 3) {
            return '<span class="badge badge-success">Settlement</span>';
        }elseif ($this->status === 4) {
            return '<span class="badge badge-primary">Done</span>';
        }
        else {
            return 'Status NotFound';
        }
    }
}
