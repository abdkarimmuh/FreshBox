<?php

namespace App\Model\Procurement;

use App\Model\Marketing\SalesOrderDetail;
use App\MyModel;
use App\Traits\SearchTraits;

class AssignProcurement extends MyModel
{
    use SearchTraits;

    protected $table = 'trx_assign_procurement';

    protected $appends = [
        'created_by_name',
        'updated_by_name',
        'sales_order_no',
        'proc_name',
        'item_name',
        'origin_code',
        'uom'
    ];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'sales_order' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'SalesOrderDetail',
            'relation_field' => 'sales_order_no'
        ],
        'item_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'SalesOrderDetail',
            'relation_field' => 'item_name'
        ],
        'qty' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'SalesOrderDetail',
            'relation_field' => 'qty'
        ],
        'uom' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'SalesOrderDetail',
            'relation_field' => 'uom'
        ],
        'proc_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'UserProc',
            'relation_field' => 'proc_name'
        ],
        'origin_code' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'UserProc',
            'relation_field' => 'origin_code'
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
            'relation_field' => 'name'
        ],
        'updated_by_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'update_by',
            'relation_field' => 'name'
        ]
    ];

    public function UserProc()
    {
        return $this->belongsTo(UserProcurement::class);
    }

    public function getProcNameAttribute()
    {
        if (isset($this->UserProc->User->name)) {
            return $this->UserProc->User->name;
        } else {
            return '';
        }
    }

    public function getOriginCodeAttribute()
    {
        if (isset($this->UserProc->Origin->description)) {
            return $this->UserProc->Origin->description;
        } else {
            return '';
        }
    }

    public function SalesOrderDetail()
    {
        return $this->belongsTo(SalesOrderDetail::class);
    }

    public function getSalesOrderNoAttribute()
    {
        if (isset($this->SalesOrderDetail->SalesOrder->sales_order_no)) {
            return $this->SalesOrderDetail->SalesOrder->sales_order_no;
        } else {
            return '';
        }
    }

    public function getItemNameAttribute()
    {
        if (isset($this->SalesOrderDetail->item->name_item)) {
            return $this->SalesOrderDetail->item->name_item;
        } else {
            return '';
        }
    }

    public function getQtyAttribute()
    {
        if (isset($this->SalesOrderDetail->qty)) {
            return $this->SalesOrderDetail->qty;
        } else {
            return '';
        }
    }

    public function getUomAttribute()
    {
        if (isset($this->SalesOrderDetail->Uom->name)) {
            return $this->SalesOrderDetail->Uom->name;
        } else {
            return '';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
