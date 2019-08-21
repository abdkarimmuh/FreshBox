<?php

namespace App\Model\MasterData;

use App\Traits\LaravelVueDatatableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use LaravelVueDatatableTrait;
    use SoftDeletes;
    protected $table = 'master_customer';

    public function CustomerGroup()
    {
        return $this->belongsTo(CustomerGroup::class);
    }

    public function CustomerType()
    {
        return $this->belongsTo(CustomerType::class);
    }
}
