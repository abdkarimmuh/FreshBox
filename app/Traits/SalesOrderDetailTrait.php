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
        } else {
            return 'Status NotFound';
        }
    }
}
