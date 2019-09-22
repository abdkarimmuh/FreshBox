<?php

namespace App\Model\Warehouse;

use App\Model\Marketing\SalesOrder;
use App\Model\MasterData\Customer;
use App\Model\MasterData\Driver;
use App\MyModel;
use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\Model;
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
    protected $fillable = ['delivery_order_no', 'sales_order_id', 'customer_id', 'do_date', 'confirm_date', 'remark', 'driver_id', 'created_by', 'created_at'];

    protected $appends = ['customer_name','sales_order_no','status_name','driver_name'];


    public function sales_order()
    {
        return $this->belongsTo(SalesOrder::class, 'sales_order_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    public function driver()
    {
        return $this->belongsTo(Driver::class, 'driver_id');
    }

    public function delivery_order_details()
    {
        return $this->hasMany(DeliveryOrderDetail::class);
    }

    public function getDriverNameAttribute()
    {
        return $this->driver->name;
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
            return '<span class="badge badge-success">Invoiced</span>';
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