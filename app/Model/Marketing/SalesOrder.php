<?php

namespace App\Model\Marketing;

use App\Model\MasterData\Customer;
use App\Model\MasterData\SourceOrder;
use App\MyModel;
use App\Traits\SearchTraits;
use App\Traits\SalesOrderTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrder extends MyModel
{
    use SoftDeletes;
    use SearchTraits;
    use SalesOrderTrait;

    protected $table = 'trx_sales_order';
    protected $appends = [
        'customer_name',
        'source_order_name',
        'updated_by_name',
        'created_by_name',
        'status_name',
        'so_no_with_cust_name'
    ];
    protected $fillable = [
        'sales_order_no',
        'customer_id',
        'no_po',
        'file',
        'source_order_id',
        'fulfillment_date',
        'remarks',
        'status',
        'created_by',
        'created_at'
    ];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'sales_order_no' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'customer_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Customer',
            'relation_field' => 'name'
        ],
        'source_order_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'SourceOrder',
            'relation_field' => 'name'
        ],
        'fulfillment_date' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'remarks' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_at' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_by' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'status' => [
            'searchable' => true,
            'search_relation' => false,
        ]
    ];

    public function getSoNoWithCustNameAttribute()
    {
        return $this->sales_order_no . ' - ' . $this->customer->name;
    }

    public function Customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function sales_order_details()
    {
        return $this->hasMany(SalesOrderDetail::class);
    }

    public function SourceOrder()
    {
        return $this->belongsTo(SourceOrder::class);
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
