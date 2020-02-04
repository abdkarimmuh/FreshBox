<?php

namespace App\Model\FinanceAP;

use App\Model\MasterData\Uom;
use App\MyModel;
use App\Traits\SearchTraits;

class SettlementDetail extends MyModel
{
    use SearchTraits;
    protected $table = 'trx_settlement_detail';
    protected $fillable = ['settlement_id', 'item_name', 'skuid', 'qty', 'uom_id', 'price', 'ppn', 'total', 'supplier_id', 'checked', 'created_at', 'updated_at'];

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
