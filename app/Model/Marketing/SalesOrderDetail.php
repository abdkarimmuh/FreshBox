<?php


namespace App\Model\Marketing;


use App\MyModel;

class SalesOrderDetail extends MyModel
{
    protected $table = 'trx_sales_order_detail';


    public function item()
    {
        return $this->belongsTo(Item::class, 'skuid', 'skuid');
    }
}
