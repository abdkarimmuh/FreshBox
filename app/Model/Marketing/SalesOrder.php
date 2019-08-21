<?php

namespace App\Model\Marketing;

use App\Config;
use App\Model\MasterData\Customer;
use App\Model\Etc\SourceOrder;
use App\Traits\LaravelVueDatatableTrait;
use App\Traits\SalesOrderTrait;
use App\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesOrder extends Config
{
    use SoftDeletes;
    use LaravelVueDatatableTrait;
    use SalesOrderTrait;

    protected $table = 'trx_sales_order';
    protected $appends = [
        'view_route',
        'edit_route',
        'delete_route',
        'customer_name',
        'source_order_name',
        'updated_by_name',
        'created_by_name',
        'status'
    ];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'sales_order_no' => [
            'searchable' => true,
        ],
        'customer_id' => [
            'searchable' => true,
        ],
        'source_id' => [
            'searchable' => false,
        ],
        'fulfillment_date' => [
            'searchable' => true,
        ],
        'remarks' => [
            'searchable' => true,
        ],
        'created_at' => [
            'searchable' => true,
        ],
        'created_by' => [
            'searchable' => true,
        ],
        'do_status' => [
            'searchable' => true,
        ],
        'so_status' => [
            'searchable' => true,
        ],
    ];

    public function Customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function SourceOrder()
    {
        return $this->belongsTo(SourceOrder::class);
    }

}
