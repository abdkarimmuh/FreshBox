<?php

namespace App\Model\FinanceAP;

use App\Model\MasterData\Vendor;
use App\MyModel;
use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\Model;

class PettyCash extends MyModel
{
    use SearchTraits;
    protected $table = 'trx_petty_cash_payment';
    protected $fillable = ['status', 'vendor_id', 'amount', 'type_transaction', 'no_trx', 'created_at', 'updated_at'];
    protected $appends = ['status_html'];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],

        'vendor_name' => [
            'searchable' => true,
            'search_relation' => false,
            'relation_name' => 'Vendor',
            'relation_field' => 'name',
        ],
        'amount' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'type_transaction' => [
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

    public function Vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function getStatusHtmlAttribute()
    {
        if ($this->status === 1) {
            return '<span class="badge badge-success">Out</span>';
        } elseif ($this->status === 2) {
            return '<span class="badge badge-danger">In</span>';
        } else {
            return 'Status NotFound';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
