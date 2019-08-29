<?php


namespace App\Traits;


Trait SalesOrderTrait
{
    function getStatusNameAttribute()
    {
        if ($this->status === 1) {
            return '<span class="badge badge-success">Open</span>';
        } elseif ($this->status === 2) {
            return '<span class="badge badge-success">Procurement</span>';
        }elseif ($this->status === 3) {
            return '<span class="badge badge-success">InBound</span>';
        }elseif ($this->status === 4) {
            return '<span class="badge badge-success">OutBound</span>';
        }elseif ($this->status === 5) {
            return '<span class="badge badge-success">Delivered</span>';
        }elseif ($this->status === 6) {
            return '<span class="badge badge-success">Submit Invoice</span>';
        }elseif ($this->status === 7) {
            return '<span class="badge badge-success">Invoicing</span>';
        }elseif ($this->status === 8) {
            return '<span class="badge badge-success">Paid</span>';
        } else {
            return 'Status NotFound';
        }
    }

    function getCustomerNameAttribute()
    {
        if (isset($this->Customer->name)) {
            return $this->Customer->name;
        } else {
            return 'Customer NotFound';
        }
    }

    function getSourceOrderNameAttribute()
    {
        if (isset($this->SourceOrder->name)) {
            return $this->SourceOrder->name;
        } else {
            return 'Source Order NotFound';
        }
    }

    function getEditRouteAttribute()
    {
        return 'editSalesOrder';
    }

    function getViewRouteAttribute()
    {
        return 'viewSalesOrder';
    }

    function getDeleteRouteAttribute()
    {
        return 'deleteSalesOrder';
    }
}
