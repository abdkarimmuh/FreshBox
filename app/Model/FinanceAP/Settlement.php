<?php

namespace App\Model\FinanceAP;

use App\MyModel;
use App\Traits\SearchTraits;

class Settlement extends MyModel
{
    use SearchTraits;
    protected $table = 'trx_settlement';
    protected $fillable = ['request_finance_id', 'status', 'no_settlement', 'file', 'remarks', 'created_by', 'created_at', 'updated_at'];
    protected $appends = ['status_html'];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'no_settlement' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'no_request' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'requestFinance',
            'relation_field' => 'no_request',
        ],
        'user_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'requestFinance.vendor',
            'relation_field' => 'name',
        ],
        'created_at' => [
            'searchable' => true,
            'search_relation' => false,
        ],
    ];

    public function requestFinance()
    {
        return $this->belongsTo(RequestFinance::class, 'request_finance_id', 'id');
    }

    public function detail()
    {
        return $this->hasMany(SettlementDetail::class, 'settlement_id', 'id');
    }

    public function getTotalAttribute()
    {
        $total = 0;
        foreach ($this->detail as $detail) {
            $total += $detail->total;
        }

        return $total;
    }

    public function getStatusHtmlAttribute()
    {
        if ($this->status === 1) {
            return '<span class="badge badge-success">Done</span>';
        } elseif ($this->status === 2) {
            return '<span class="badge badge-danger">Remaining Money</span>';
        } elseif ($this->status === 3) {
            return '<span class="badge badge-danger">Less Money</span>';
        } else {
            return 'Status NotFound';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
