<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PriceTemp extends Model
{
    protected $table = 'price_temp';
    protected $primaryKey = 'No';
    protected $fillable = ['No', 'Category', 'SKU', 'Items', 'Unit', 'Pricelist', 'Discount', 'Final', 'Remarks', 'customer_group_id', 'End_Period', 'AuditDate', 'start_period', 'updated_at'];
    public $incrementing = false;

}
