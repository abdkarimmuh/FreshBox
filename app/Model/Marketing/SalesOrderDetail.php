<?php

namespace App\Model\Marketing;

use App\Model\MasterData\Item;
use App\Model\MasterData\Uom;
use App\MyModel;
use App\Traits\SalesOrderDetailTrait;
use App\Traits\SearchTraits;

class SalesOrderDetail extends MyModel
{
    use SearchTraits;
    use SalesOrderDetailTrait;

    protected $table = 'trx_sales_order_detail';
    protected $appends = ['item_name', 'uom_name', 'origin_code', 'sales_order_no', 'po_no', 'so_date', 'category_name', 'delivery_order_no', 'assign_qty', 'no_po', 'so_no_with_item_name'];
    protected $fillable = [
        'so_no_with_item_name',
        'sales_order_id',
        'uom_id',
        'qty',
        'sisa_qty_proc',
        'skuid',
        'tax_value',
        'amount_price',
        'total_amount',
        'notes',
        'created_by',
        'status',
    ];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'customer_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'SalesOrder.Customer',
            'relation_field' => 'name',
        ],
        'sales_order_no' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'SalesOrder',
            'relation_field' => 'sales_order_no',
        ],
        'driver_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'SalesOrder.Driver',
            'relation_field' => 'name',
        ],
        'fulfillment_date' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'SalesOrder',
            'relation_field' => 'fulfillment_date',
        ],
        'created_at' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_by' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'status' => [
            'searchable' => true,
            'search_relation' => false,
        ],
    ];

    public function Item()
    {
        return $this->belongsTo(Item::class, 'skuid', 'skuid');
    }

    public function SalesOrder()
    {
        return $this->belongsTo(SalesOrder::class);
    }

    public function Uom()
    {
        return $this->belongsTo(Uom::class, 'uom_id', 'id');
    }

    public function getAssignQtyAttribute()
    {
        return floatval($this->qty - $this->sisa_qty_proc);
    }

    public function getItemNameAttribute()
    {
        if (isset($this->Item->name_item)) {
            return $this->Item->name_item;
        }
    }

    public function getUomNameAttribute()
    {
        if (isset($this->Uom->name)) {
            return $this->Uom->name;
        }
    }

    public function getOriginCodeAttribute()
    {
        if (isset($this->Item->origin_code)) {
            return $this->Item->origin_code;
        }
    }

    public function getSalesOrderNoAttribute()
    {
        if (isset($this->SalesOrder->sales_order_no)) {
            return $this->SalesOrder->sales_order_no;
        }
    }

    public function getCustomerNameAttribute()
    {
        return $this->SalesOrder->customer_name ?? null;
    }

    public function getPoNoAttribute()
    {
        return $this->SalesOrder->no_po ?? null;
    }

    public function getSoDateAttribute()
    {
        if (isset($this->SalesOrder->fulfillment_date)) {
            return $this->SalesOrder->fulfillment_date->formatLocalized('%d %B %Y') ?? null;
        } else {
            return null;
        }
    }

    public function getTanggalAttribute()
    {
        if (isset($this->SalesOrder->created_at)) {
            return $this->SalesOrder->created_at->formatLocalized('%m/%d/%Y') ?? null;
        } else {
            return null;
        }
    }

    public function getCategoryNameAttribute()
    {
        return $this->item->category_name ?? null;
    }

    public function getDeliveryOrderNoAttribute()
    {
        return $this->SalesOrder->DeliveryOrder->delivery_order_no ?? null;
    }

    public function getSoNoWithItemNameAttribute()
    {
        return $this->sales_order_no.' - '.$this->item_name;
    }

    public function getNoPoAttribute()
    {
        return $this->SalesOrder->no_po;
    }
}
