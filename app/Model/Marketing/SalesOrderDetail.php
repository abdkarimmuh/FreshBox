<?php


namespace App\Model\Marketing;


use App\Model\MasterData\Item;
use App\Model\MasterData\Uom;
use App\MyModel;

class SalesOrderDetail extends MyModel
{
    protected $table = 'trx_sales_order_detail';
    protected $appends = ['item_name', 'uom_name'];

    public function item()
    {
        return $this->belongsTo(Item::class, 'skuid', 'skuid');
    }

    public function uom()
    {
        return $this->belongsTo(Uom::class, 'uom_id', 'id');
    }

    public function getItemNameAttribute()
    {
        return $this->item->name_item;
    }

    public function getUomNameAttribute()
    {
        return $this->uom->name;
    }
}
