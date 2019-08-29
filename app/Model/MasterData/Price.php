<?php

namespace App\Model\MasterData;

use App\MyModel;
use App\Traits\SearchTraits;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends MyModel
{
    use SearchTraits;
    use SoftDeletes;

    protected $table = 'master_price';

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function uom()
    {
        return $this->belongsTo(Uom::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function item()
    {
        return $this->belongsTo(Item::class, 'skuid', 'skuid');
    }
}
