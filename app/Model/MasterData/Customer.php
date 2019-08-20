<?php

namespace App\Model\MasterData;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use SoftDeletes;
    protected $table = 'fresh_customer';

    public function CustomerGroup()
    {
        return $this->belongsTo(CustomerGroup::class);
    }

    public function CustomerType()
    {
        return $this->belongsTo(CustomerType::class);
    }
}
