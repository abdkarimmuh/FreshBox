<?php

namespace App\Model\FinanceAP;

use App\Model\MasterData\Vendor;
use App\Model\MasterData\Bank;
use App\MyModel;
use App\Traits\SearchTraits;

class InOutPayment extends MyModel
{
    use SearchTraits;
    protected $table = 'trx_in_out_payment';
    protected $fillable = ['finance_request_id', 'source', 'transaction_date', 'bank_id', 'no_rek', 'amount', 'remarks', 'status', 'type_transaction', 'created_at', 'update_at'];
    protected $appends = ['status_html'];


    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'source' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'bank_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'bank',
            'relation_field' => 'name',
        ],
        'amount' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'type_transaction' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'created_at' => [
            'searchable' => true,
            'search_relation' => false,
        ],
    ];

    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function RequestFinance()
    {
        return $this->belongsTo(RequestFinance::class, 'finance_request_id', 'id');
    }


    public function getStatusHtmlAttribute()
    {
        if ($this->status === 2) {
            return '<span class="badge badge-info">Uploaded</span>';
        } elseif ($this->status === 3) {
            return '<span class="badge badge-primary">Receive</span>';
        } elseif ($this->status === 4) {
            return '<span class="badge badge-warning">Confirm</span>';
        } else {
            return 'Status NotFound';
        }
    }

    public function getTypeHtmlAttribute()
    {
        if ($this->type_transaction === 1) {
            return '<span class="badge badge-primary">OUT</span>';
        } elseif ($this->type_transaction === 2) {
            return '<span class="badge badge-dark">IN</span>';
        } else {
            return 'Status NotFound';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
