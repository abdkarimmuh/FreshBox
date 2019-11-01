<?php

namespace App\Model\WarehouseIn;

use App\Model\Procurement\ListProcurementDetail;
use App\MyModel;
use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConfirmDetail extends MyModel
{
    use SearchTraits;
    use SoftDeletes;

    protected $table = 'trx_warehouse_confirm_detail';

    protected $fillable = ['warehouse_confirm_id', 'list_proc_detail_id', 'bruto', 'netto', 'created_by', 'created_at'];
    protected $appends = [
        'item_name',
        'qty_proc',
        'uom_name',
    ];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'item_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'ListProcurementDetail',
            'relation_field' => 'item_name',
        ],
        'created_at' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_at' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'updated_at' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_by_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'create_by',
            'relation_field' => 'name',
        ],
        'updated_by_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'update_by',
            'relation_field' => 'name',
        ],
    ];

    public function Confirm()
    {
        return $this->belongsTo(Confirm::class, 'warehouse_confirm_id', 'id');
    }

    public function ListProcurementDetail()
    {
        return $this->belongsTo(ListProcurementDetail::class, 'list_proc_detail_id', 'id');
    }

    public function getItemNameAttribute()
    {
        if (isset($this->ListProcurementDetail->AssignProcurement->Item->name_item)) {
            return $this->ListProcurementDetail->AssignProcurement->Item->name_item;
        } else {
            return '';
        }
    }

    public function getQtyProcAttribute()
    {
        if (isset($this->ListProcurementDetail->qty)) {
            return $this->ListProcurementDetail->qty;
        }
    }

    public function getUomNameAttribute()
    {
        if (isset($this->ListProcurementDetail->Uom->name)) {
            return $this->ListProcurementDetail->Uom->name;
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
