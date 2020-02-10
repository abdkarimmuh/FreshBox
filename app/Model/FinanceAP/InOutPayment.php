<?php

namespace App\Model\FinanceAP;

use App\Model\MasterData\Bank;
use App\MyModel;
use App\Traits\SearchTraits;

class InOutPayment extends MyModel
{
    use SearchTraits;
    protected $table = 'trx_in_out_payment';
    protected $fillable = ['type_transaction', 'option_transaction', 'finance_request_id', 'source', 'transaction_date', 'bank_id', 'bank_account', 'amount', 'remarks', 'file', 'status',  'created_at', 'update_at'];
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
            return '<span class="badge badge-warning">Upload Document</span>';
        } elseif ($this->status === 3) {
            return '<span class="badge badge-info">Receive Document</span>';
        } elseif ($this->status === 4) {
            return '<span class="badge badge-success">Confirm</span>';
        } elseif ($this->status === 5) {
            return '<span class="badge badge-primary">Remaining Money</span>';
        } elseif ($this->status === 6) {
            return '<span class="badge badge-danger">Less Money</span>';
        } elseif ($this->status === 7) {
            return '<span class="badge badge-danger">Reject Document</span>';
        } else {
            return 'Status NotFound';
        }
    }

    public function getTypeHtmlAttribute()
    {
        if ($this->type_transaction === 1) {
            return 'In Payment';
        } elseif ($this->type_transaction === 2) {
            return 'Out Payment';
        } else {
            return 'Status NotFound';
        }
    }

    public function getOptionHtmlAttribute()
    {
        if ($this->type_transaction === 1) {
            if ($this->option_transaction === 0) {
                return '<span class="badge badge-primary">Request Cash Advance</span>';
            } elseif ($this->option_transaction === 1) {
                return '<span class="badge badge-secondary">Setlement Advance</span>';
            } elseif ($this->option_transaction === 2) {
                return '<span class="badge badge-warning">Replacement</span>';
            } elseif ($this->option_transaction === 3) {
                return '<span class="badge badge-info">General Income</span>';
            } else {
                return 'Status NotFound';
            }
        } elseif ($this->type_transaction === 2) {
            if ($this->option_transaction === 0) {
                return '<span class="badge badge-primary">Request Cash Advance</span>';
            } elseif ($this->option_transaction === 1) {
                return '<span class="badge badge-secondary">Setlement Advance</span>';
            } elseif ($this->option_transaction === 2) {
                return '<span class="badge badge-warning">Reimbursment</span>';
            } elseif ($this->option_transaction === 3) {
                return '<span class="badge badge-info">General Payment</span>';
            } else {
                return 'Status NotFound';
            }
        } else {
            return 'Status NotFound';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
