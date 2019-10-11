<?php

namespace App\Model\Warehouse;

use App\Http\Resources\SalesOrderDetailResource;
use App\Model\Marketing\SalesOrderDetail;
use App\Model\MasterData\Item;
use App\Model\MasterData\Uom;
use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrderDetail extends Model
{
    use SearchTraits;
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'trx_delivery_order_detail';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['delivery_order_id', 'skuid', 'sales_order_detail_id', 'qty_do', 'qty_confirm', 'uom_id', 'qty_minus', 'remark', 'created_by', 'updated_by'];
    protected $appends = ['total_amount', 'amount_price','total_amount_do'];

    public function delivery_order()
    {
        return $this->belongsTo(DeliveryOrder::class, 'delivery_order_id');
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'skuid', 'skuid');
    }

    public function sales_order_detail()
    {
        return $this->belongsTo(SalesOrderDetail::class, 'sales_order_detail_id');
    }

    public function uom()
    {
        return $this->belongsTo(Uom::class, 'uom_id');
    }

    public function getAmountPriceAttribute()
    {
        return $this->sales_order_detail->amount_price;
    }

    public function getTotalAmountDoAttribute()
    {
        return $this->sales_order_detail->amount_price * $this->qty_do;
    }

    public function getTotalAmountAttribute()
    {
        return $this->amount_price * $this->qty_confirm;
    }
}
