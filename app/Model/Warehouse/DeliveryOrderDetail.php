<?php

namespace App\Model\Warehouse;

use App\Http\Resources\SalesOrderDetailResource;
use App\Model\MasterData\Item;
use App\Model\MasterData\Uom;
use Illuminate\Database\Eloquent\Model;

class DeliveryOrderDetail extends Model
{
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
    protected $fillable = ['delivery_order_id', 'skuid', 'sales_order_detail_id', 'qty_do', 'qty_confirm', 'uom_id', 'returned', 'remark', 'created_by', 'updated_by'];

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
        return $this->belongsTo(SalesOrderDetailResource, 'sales_order_detail_id');
    }

    public function uom()
    {
        return $this->belongsTo(Uom::class, 'uom_id');
    }

}
