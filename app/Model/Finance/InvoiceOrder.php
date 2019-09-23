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
    protected $fillable = ['invoice_no', 'id_so', 'id_do', 'invoice_date', 'status'];
    protected $appends = ['delivery_order_no', 'sales_order_no', 'customer_name', 'total_amount'];

    public function sales_order()
    {
        return $this->belongsTo(SalesOrder::class, 'id_so');
    }

    public function delivery_order()
    {
        return $this->belongsTo(DeliveryOrder::class, 'id_do')->whereHas('delivery_order_details', function ($q) {
            $q->where('returned', 0);
        });
    }

    public function getDeliveryOrderNoAttribute()
    {
        return $this->delivery_order->delivery_order_no;
    }

    public function getSalesOrderNoAttribute()
    {
        return $this->sales_order->sales_order_no;
    }

    public function getCustomerNameAttribute()
    {
        return $this->sales_order->customer_name;
    }

    public function getTotalAmountAttribute()
    {
        $total_amount = 0;
        foreach ($this->delivery_order->delivery_order_details as $do_details) {
            $total_amount += $do_details->sales_order_detail->total_amount;
        }
        return number_format($total_amount, 2);
    }

    public function getStatusNameAttribute()
    {
        if ($this->sales_order->status === 6) {
            return '<span class="badge badge-info">Open</span>';
        } elseif ($this->sales_order->status === 7) {
            return '<span class="badge badge-warning">Printed</span>';
        } elseif ($this->sales_order->status === 8) {
            return '<span class="badge badge-success">Paid</span>';
        } elseif ($this->sales_order->status === 9) {
            return '<span class="badge badge-danger">Returned</span>';
        } else {
            return 'Status NotFound';
        }
    }
}
