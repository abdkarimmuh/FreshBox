<?php


namespace App\Traits;


use Illuminate\Support\Facades\Storage;

Trait DriverTrait
{
    function getRoleNameAttribute()
    {
        if ($this->role === 1) {
            return 'Driver';
        } elseif ($this->role === 2) {
            return 'PIC QC';
        } else {
            return 'Role Not Found';
        }
    }
}
