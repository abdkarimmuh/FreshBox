<?php

namespace App\Traits;

trait SalesOrderDetailTrait
{
    public function getStatusNameAttribute()
    {
        if ($this->status === 1) {
            return '<span class="badge badge-light">Open</span>';
        } elseif ($this->status === 2) {
            return '<span class="badge badge-info">Pick</span>';
        } elseif ($this->status === 3) {
            return '<span class="badge badge-primary">Procure</span>';
        } elseif ($this->status === 4) {
            return '<span class="badge badge-success">Confirm</span>';
        } else {
            return 'Status NotFound';
        }
    }
}
