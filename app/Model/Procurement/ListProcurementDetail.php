<?php

namespace App\Model\Procurement;

use App\MyModel;
use App\Traits\SearchTraits;

class ListProcurementDetail extends MyModel
{
    use SearchTraits;

    protected $table = 'trx_list_procurement_detail';
    protected $fillable = ['trx_list_procurement_id', 'trx_assign_procurement_id', 'qty', 'qty_minus', 'uom_id', 'amount', 'created_by', 'created_at'];

    public function ListProcurement()
    {
        return $this->belongsTo(ListProcurement::class);
    }

    public function AssignProcurement()
    {
        return $this->belongsTo(AssignProcurement::class);
    }
}
