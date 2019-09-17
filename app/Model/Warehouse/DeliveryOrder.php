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

    protected $appends = ['customer_name','sales_order_no','status_name'];


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
        return $this->sales_order->status_name;
    }
}
