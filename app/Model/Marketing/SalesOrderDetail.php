<?php

namespace App\Model\Marketing;

use App\Model\MasterData\Item;
use App\Model\MasterData\Uom;
use App\MyModel;
use App\Traits\SalesOrderDetailTrait;
use App\Traits\SearchTraits;

class SalesOrderDetail extends MyModel
{
    use SearchTraits;
    use SalesOrderDetailTrait;

    protected $table = 'trx_sales_order_detail';
    protected $appends = ['item_name', 'uom_name', 'origin_code', 'sales_order_no'];
    protected $fillable = [
        'sales_order_id',
        'qty',
        'skuid',
        'amount_price',
        'total_amount',
        'notes',
        'created_by',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class, 'skuid', 'skuid');
    }

    public function SalesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function uom()
    {
        return $this->belongsTo(Uom::class, 'uom_id', 'id');
    }

    public function getItemNameAttribute()
    {
        if (isset($this->item->name_item)) {
            return $this->item->name_item;
        }
    }

    public function getUomNameAttribute()
    {
        if (isset($this->uom->name)) {
            return $this->uom->name;
        }
    }

    public function getOriginCodeAttribute()
    {
        if (isset($this->item->origin_code)) {
            return $this->item->origin_code;
        }
    }

    public function getSalesOrderNoAttribute()
    {
        if (isset($this->SalesOrder->sales_order_no)) {
            return $this->SalesOrder->sales_order_no;
        }
    }
}
