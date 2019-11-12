<?php

namespace App\Model\Procurement;

use App\Model\Marketing\SalesOrderDetail;
use Illuminate\Database\Eloquent\Model;

class AssignSalesOrderDetail extends Model
{
    protected $table = 'assign_sales_order_detail';
    protected $fillable = ['sales_order_detail_id', 'assign_id'];

    public function AssignProcurement()
    {
        return $this->belongsTo(AssignProcurement::class, 'assign_id', 'id');
    }

    public function SalesOrderDetail()
    {
        return $this->belongsTo(SalesOrderDetail::class, 'sales_order_detail_id', 'id');
    }
}
