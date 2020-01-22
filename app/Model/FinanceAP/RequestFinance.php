<?php

namespace App\Model\FinanceAP;

use App\Model\MasterData\Vendor;
use App\Model\MasterData\Warehouse;
use App\MyModel;
use App\Traits\SearchTraits;

class RequestFinance extends MyModel
{
    use SearchTraits;
    protected $table = 'finance_request';
    protected $fillable = ['status', 'vendor_id', 'master_warehouse_id', 'no_request', 'request_date', 'no_request_confirm', 'request_confirm_date', 'request_type', 'product_type', 'created_by', 'file', 'created_at', 'updated_at'];
    protected $dates = [
        'request_date',
        'request_confirm_date',
    ];

    protected $appends = ['status_html'];

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
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
        } elseif ($this->status === 4) {
            return '<span class="badge badge-primary">Done</span>';
        } else {
            return 'Status NotFound';
        }
    }
}
