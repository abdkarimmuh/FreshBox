<?php

namespace App\Model\WarehouseIn;

use App\Model\Marketing\SalesOrderDetail;
use App\MyModel;
use App\Traits\SearchTraits;

class PackageItem extends MyModel
{
    use SearchTraits;

    protected $table = 'trx_package_item';
    protected $fillable = ['so_detail_id', 'status', 'created_by', 'created_at'];
    protected $appends = [
        'sales_order_no',
        'item_name',
        'status_name',
    ];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'sales_order_no' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'SalesOrderDetail',
            'relation_field' => 'sales_order_no',
        ],
        'item_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'SalesOrderDetail',
            'relation_field' => 'item_name',
        ],
        'status_name' => [
            'searchable' => true,
            'search_relation' => true,
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
    ];

    public function SalesOrderDetail()
    {
        return $this->belongsTo(SalesOrderDetail::class, 'so_detail_id', 'id');
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
        if (isset($this->SalesOrderDetail->Item->name_item)) {
            return $this->SalesOrderDetail->Item->name_item;
        } else {
            return '';
        }
    }

    public function getStatusNameAttribute()
    {
        if ($this->status == 1) {
            return '<span class="badge badge-info">Packing Item</span>';
        } elseif ($this->status == 2) {
            return '<span class="badge badge-danger">Generate Label</span>';
        } else {
            return 'Status NotFound';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
