<?php

namespace App\Model\Finance;

use App\Model\Marketing\SalesOrder;
use App\Model\Warehouse\DeliveryOrder;
use App\MyModel;
use App\Traits\SearchTraits;

class InvoiceOrder extends MyModel
{
    use SearchTraits;
    protected $table = 'trx_invoice';
    protected $fillable = ['invoice_no', 'do_id', 'invoice_date', 'created_by','customer_id'];
    protected $appends = ['delivery_order_no', 'sales_order_no', 'customer_name', 'total_price', 'invoice_date_formatted'];
    protected $dates = ['invoice_date'];

    public function delivery_order()
    {
        return $this->belongsTo(DeliveryOrder::class, 'do_id');
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

    public function getCustomerNameAttribute()
    {
        return $this->delivery_order->sales_order->customer_name;
    }

    public function getTotalPriceAttribute()
    {
        $total_amount = 0;
        foreach ($this->delivery_order->do_details_not_returned as $do_details) {
            $total_amount += $do_details->sales_order_detail->total_amount;
        }
        return $total_amount;
    }

    public function getStatusNameAttribute()
    {
        if ($this->delivery_order->sales_order->status === 6) {
            return '<span class="badge badge-info">Open</span>';
        } elseif ($this->delivery_order->sales_order->status === 7) {
            return '<span class="badge badge-warning">Printed</span>';
        } elseif ($this->delivery_order->sales_order->status === 8) {
            return '<span class="badge badge-success">Paid</span>';
        } elseif ($this->delivery_order->sales_order->status === 9) {
            return '<span class="badge badge-danger">Returned</span>';
        } else {
            return 'Status NotFound';
        }
    }
}
