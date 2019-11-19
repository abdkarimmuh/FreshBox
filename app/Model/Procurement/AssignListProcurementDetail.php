<?php

namespace App\Model\Procurement;

use Illuminate\Database\Eloquent\Model;

class AssignListProcurementDetail extends Model
{
    protected $table = 'assign_list_procurement';
    protected $fillable = ['list_procurement_detail_id', 'assign_id'];



    public function AssignProcurement()
    {
        return $this->belongsTo(AssignProcurement::class, 'assign_id', 'id');
    }

    public function ListProcurementDetail()
    {
        return $this->belongsTo(ListProcurementDetail::class, 'list_procurement_detail_id', 'id');
    }
}
