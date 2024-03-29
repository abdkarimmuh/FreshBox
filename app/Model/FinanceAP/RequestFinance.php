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
    protected $fillable = ['status', 'vendor_id', 'master_warehouse_id', 'no_request', 'request_date', 'no_payment', 'confirm_date', 'request_type', 'product_type', 'created_by', 'file', 'created_at', 'updated_at'];
    protected $dates = ['request_date', 'request_confirm_date', 'price', 'total'];
    protected $appends = ['status_html', 'user_name'];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'no_request' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'user_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'vendor',
            'relation_field' => 'name',
        ],
        'created_at' => [
            'searchable' => true,
            'search_relation' => false,
        ],
    ];

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

    public function getPriceAttribute()
    {
        $price = 0;
        foreach ($this->detail as $detail) {
            $price += $detail->price;
        }

        return $price;
    }

    public function getUserNameAttribute()
    {
        return isset($this->vendor) ? $this->vendor->name : '';
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
            return '<span class="badge badge-warning">Upload Document</span>';
        } elseif ($this->status === 3) {
            return '<span class="badge badge-warning">Receive Document</span>';
        } elseif ($this->status === 4) {
            return '<span class="badge badge-success">Paid</span>';
        } elseif ($this->status === 5) {
            return '<span class="badge badge-primary">Settlement</span>';
        } elseif ($this->status === 6) {
            return '<span class="badge badge-danger">Remaining Money</span>';
        } elseif ($this->status === 7) {
            return '<span class="badge badge-danger">Less Money</span>';
        } elseif ($this->status === 8) {
            return '<span class="badge badge-danger">Reject Document</span>';
        } else {
            return 'Status NotFound';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
