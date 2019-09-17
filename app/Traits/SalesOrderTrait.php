<?php


namespace App\Traits;


use Illuminate\Support\Facades\Storage;

Trait SalesOrderTrait
{
    function getStatusNameAttribute()
    {
        if ($this->status === 1) {
            return '<span class="badge badge-info">Open</span>';
        } elseif ($this->status === 2) {
            return '<span class="badge badge-info">Procurement</span>';
        } elseif ($this->status === 3) {
            return '<span class="badge badge-primary">InBound</span>';
        } elseif ($this->status === 4) {
            return '<span class="badge badge-primary">OutBound</span>';
        } elseif ($this->status === 5) {
            return '<span class="badge badge-primary">Delivered</span>';
        } elseif ($this->status === 6) {
            return '<span class="badge badge-warning">Submit Invoice</span>';
        } elseif ($this->status === 7) {
            return '<span class="badge badge-warning">Invoicing</span>';
        } elseif ($this->status === 8) {
            return '<span class="badge badge-success">Paid</span>';
        } elseif ($this->status === 9) {
            return '<span class="badge badge-danger">Returned</span>';
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
}
