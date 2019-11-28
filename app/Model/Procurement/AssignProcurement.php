<?php

namespace App\Model\Procurement;

use App\Model\Marketing\SalesOrderDetail;
use App\Model\MasterData\Item;
use App\Model\MasterData\Uom;
use App\MyModel;
use App\Traits\SearchTraits;

class AssignProcurement extends MyModel
{
    use SearchTraits;

    protected $table = 'trx_assign_procurement';
    protected $fillable = ['skuid', 'status', 'user_proc_id', 'sales_order_detail_id', 'created_by'];

    protected $appends = [
        'created_by_name',
        'updated_by_name',
        'proc_name',
        'item_name',
        'uom_name',
    ];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'skuid' => [
            'searchable' => true,
            'search_relation' => true,
        ],
        'item_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Item',
            'relation_field' => 'item_name',
        ],
        'qty' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'uom_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Uom',
            'relation_field' => 'uom_name',
        ],
        'proc_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'UserProc',
            'relation_field' => 'proc_name',
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

    public function UserProc()
    {
        return $this->belongsTo(UserProcurement::class, 'user_proc_id', 'id');
    }

    public function SalesOrderDetail()
    {
        return $this->belongsTo(SalesOrderDetail::class, 'sales_order_detail_id', 'id');
    }

    public function AssignProcurementDetail()
    {
        return $this->hasMany(AssignProcurementDetail::class, 'assign_id', 'id');
    }

    public function getProcNameAttribute()
    {
        if (isset($this->UserProc->User->name)) {
            return $this->UserProc->User->name;
        } else {
            return '';
        }
    }

    public function Item()
    {
        return $this->belongsTo(Item::class, 'skuid', 'skuid');
    }

    public function getItemNameAttribute()
    {
        if (isset($this->item->name_item)) {
            return $this->item->name_item;
        } else {
            return '';
        }
    }

    public function Uom()
    {
        return $this->belongsTo(Uom::class);
    }

    public function getUomNameAttribute()
    {
        if (isset($this->Uom->name)) {
            return $this->Uom->name;
        } else {
            return '';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
