<?php

namespace App\Model\FinanceAp;

// use Illuminate\Database\Eloquent\Model;

use App\Model\MasterData\Vendor;
use App\MyModel;
use App\Traits\SearchTraits;

class InOutPayment extends MyModel
{
    use SearchTraits;
    protected $table = 'trx_in_out_payment';
    protected $fillable = ['status', 'vendor_id', 'amount', 'type_transaction', 'created_at', 'update_at'];
    protected $appends = ['status_html'];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'vendor_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'vendor',
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

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }

    public function getStatusHtmlAttribute()
    {
        if ($this->status === 1) {
            return '<span class="badge badge-danger">OUT</span>';
        } elseif ($this->status === 2) {
            return '<span class="badge badge-success">IN</span>';
        } else {
            return 'Status NotFound';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
