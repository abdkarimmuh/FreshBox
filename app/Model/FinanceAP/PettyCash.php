<?php

namespace App\Model\FinanceAP;

use App\MyModel;
use App\Traits\SearchTraits;

class PettyCash extends MyModel
{
    use SearchTraits;
    protected $table = 'trx_petty_cash_payment';
    protected $fillable = ['finance_request_id', 'amount', 'no_trx', 'created_at', 'updated_at'];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],

        'user_request_name' => [
            'searchable' => true,
            'search_relation' => false,
            'relation_name' => 'RequestFinance',
            'relation_field' => 'user.name',
        ],
        'amount' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'no_trx' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_at' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_by_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'create_by',
            'relation_field' => 'name',
        ],
    ];

    public function RequestFinance()
    {
        return $this->belongsTo(RequestFinance::class, 'finance_request_id', 'id');
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
