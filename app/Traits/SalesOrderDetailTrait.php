<?php

namespace App\Traits;

trait SalesOrderDetailTrait
{
    public function getStatusNameAttribute()
    {
        if ($this->status === 1) {
            return '<span class="badge badge-info">Open</span>';
        } elseif ($this->status === 2) {
            return '<span class="badge badge-primary">Pick</span>';
        } elseif ($this->status === 3) {
            return '<span class="badge badge-primary">Procure</span>';
        } elseif ($this->status === 4) {
            return '<span class="badge badge-primary">Package</span>';
        } else {
            return 'Status NotFound';
        }
    }
}
