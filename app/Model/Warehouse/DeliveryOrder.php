<?php

namespace App\Model\Warehouse;

use App\Model\Finance\InvoiceOrder;
use App\Model\Marketing\SalesOrder;
use App\Model\MasterData\Customer;
use App\Model\MasterData\Driver;
use App\MyModel;
use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\SoftDeletes;

class DeliveryOrder extends MyModel
{
    use SearchTraits;
    use SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trx_delivery_order';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['delivery_order_no', 'sales_order_id', 'customer_id', 'do_date', 'pic_qc', 'confirm_date', 'remark', 'driver_id', 'created_by', 'created_at'];

    protected $appends = ['customer_name', 'sales_order_no', 'status_name', 'driver_name', 'pic_qc_name']; //finction dibawah
    protected $dates = ['do_date'];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'delivery_order_no' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'customer_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'customer',
            'relation_field' => 'name',
        ],
        'sales_order_no' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'sales_order',
            'relation_field' => 'sales_order_no',
        ],
        'driver_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'driver',
            'relation_field' => 'name',
        ],
    ];


    public function sales_order()
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id');
    }

    public function invoice()
    {
        return $this->belongsTo(InvoiceOrder::class, 'id', 'do_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function picqc()
    {
        return $this->belongsTo(Driver::class, 'pic_qc');
    }

    public function delivery_order_details()
    {
        return $this->hasMany(DeliveryOrderDetail::class);
    }

    public function do_details_returned()
    {
        return $this->hasMany(DeliveryOrderDetail::class)->where('qty_minus', '<>', 0);
    }

    public function getDriverNameAttribute()
    {
        return $this->driver->name;
    }

    public function getPicQcNameAttribute()
    {
        return $this->picqc->name ?? null;
    }

    public function getCustomerNameAttribute()
    {
        return $this->customer->name;
    }

    public function getSalesOrderNoAttribute()
    {
        return $this->sales_order->sales_order_no;
    }

    public function getStatusNameAttribute()
    {
        if ($this->sales_order->status === 4) {
            return '<span class="badge badge-info">Open</span>';
        } elseif ($this->sales_order->status === 5) {
            return '<span class="badge badge-warning">Confirmed</span>';
        } elseif ($this->sales_order->status === 6) {
            return '<span class="badge badge-success">Submit Invoice</span>';
        } elseif ($this->sales_order->status === 7) {
            return '<span class="badge badge-success">Invoicing</span>';
        } elseif ($this->sales_order->status === 8) {
            return '<span class="badge badge-success">Paid</span>';
        } elseif ($this->sales_order->status === 9) {
            return '<span class="badge badge-danger">Returned</span>';
        } else {
            return 'Status NotFound';
        }
    }

}
