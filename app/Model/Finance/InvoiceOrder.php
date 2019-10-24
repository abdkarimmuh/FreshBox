<?php

namespace App\Model\Finance;

use App\Model\Marketing\SalesOrder;
use App\Model\MasterData\Customer;
use App\Model\Warehouse\DeliveryOrder;
use App\MyModel;
use App\Traits\SearchTraits;

class InvoiceOrder extends MyModel
{
    use SearchTraits;
    protected $table = 'trx_invoice';
    protected $fillable = ['invoice_no', 'do_id', 'invoice_date', 'created_by', 'customer_id'];
    protected $appends = ['delivery_order_no', 'sales_order_no', 'customer_name', 'total_price', 'invoice_date_formatted', 'no_po','tgl'];
    protected $dates = ['invoice_date'];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'invoice_no' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'customer_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Customer',
            'relation_field' => 'name',
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
            'search_relation' => true,
            'relation_name' => 'delivery_order.sales_order',
            'relation_field' => 'status',
        ],
    ];


    public function delivery_order()
    {
        return $this->belongsTo(DeliveryOrder::class, 'do_id');
    }

    public function Customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getInvoiceDateFormattedAttribute()
    {
        return $this->invoice_date->formatLocalized('%d %B %Y');
    }

    public function getDeliveryOrderNoAttribute()
    {
        return $this->delivery_order->delivery_order_no;
    }

    public function getSalesOrderNoAttribute()
    {
        return $this->delivery_order->sales_order->sales_order_no;
    }

    public function getNoPoAttribute()
    {
        return $this->delivery_order->sales_order->no_po;
    }

    public function getCustomerNameAttribute()
    {
        return $this->delivery_order->sales_order->customer_name;
    }

    public function getTglAttribute()
    {
        return $this->delivery_order->sales_order->fulfillment_date;


    }

    public function getTotalPriceAttribute()
    {
        $total_amount = 0;
        foreach ($this->delivery_order->delivery_order_details as $do_details) {
            $total_amount += $do_details->sales_order_detail->amount_price * $do_details->qty_confirm;
        }
        return $total_amount;
    }

    public function getStatusNameAttribute()
    {
        if ($this->delivery_order->sales_order->status === 6) {
            return '<span class="badge badge-info">Open</span>';
        } elseif ($this->delivery_order->sales_order->status === 7) {
            return '<span class="badge badge-warning">Recap</span>';
        } elseif ($this->delivery_order->sales_order->status === 8) {
            return '<span class="badge badge-success">Paid</span>';
        } elseif ($this->delivery_order->sales_order->status === 9) {
            return '<span class="badge badge-danger">Returned</span>';
        } else {
            return 'Status NotFound';
        }
    }

}
