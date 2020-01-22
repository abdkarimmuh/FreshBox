<?php

namespace App\Model\FinanceAP;

use App\Model\MasterData\Uom;
use Illuminate\Database\Eloquent\Model;

class RequestFinanceDetail extends Model
{
    protected $table = 'finance_request_detail';
    protected $appends = ['uom_name'];

    public function Uom()
    {
        return $this->belongsTo(Uom::class, 'uom_id', 'id');
    }
    public function getUomNameAttribute()
    {
        return $this->Uom->name;
    }
}
