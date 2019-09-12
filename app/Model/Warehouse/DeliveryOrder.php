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

    protected $table = 'trx_delivery_order';
    protected $appends = [];

    protected $fillable = [];

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
}
