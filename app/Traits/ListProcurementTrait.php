<?php

namespace App\Traits;

trait ListProcurementTrait
{
    public function getStatusNameAttribute()
    {
        if ($this->status === 1) {
            return '<span class="badge badge-info">Pick</span>';
        } elseif ($this->status === 2) {
            return '<span class="badge badge-primary">Submit</span>';
        } elseif ($this->status === 3) {
            return '<span class="badge badge-warning">Recive</span>';
        } elseif ($this->status === 4) {
            return '<span class="badge badge-danger">Return</span>';
        } elseif ($this->status === 5) {
            return '<span class="badge badge-success">Replenish</span>';
        } else {
            return 'Status NotFound';
        }
    }
}
