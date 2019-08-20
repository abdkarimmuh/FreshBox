<?php


namespace App\Traits;


Trait SalesOrderTrait
{
    function getCreatedByNameAttribute()
    {
        if (isset($this->create_by->name)) {
            return $this->create_by->name;
        } else {
            return '';
        }
    }

    function getUpdatedByNameAttribute()
    {
        if (isset($this->edit_by->name)) {
            return $this->edit_by->name;
        } else {
            return '';
        }
    }


    function getStatusAttribute()
    {
        if ($this->so_status == 1 && $this->do_status == 0) {
            return '<span class="badge badge-success">Open</span>';
        } else {
            return 'Status NotFound';
        }
    }

    function getCustomerNameAttribute()
    {
        if (isset($this->Customer->customer_name)) {
            return $this->Customer->customer_name;
        } else {
            return 'Customer NotFound';
        }
    }

    function getSourceOrderNameAttribute()
    {
        if (isset($this->SourceOrder->source_order)) {
            return $this->SourceOrder->source_order;
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
