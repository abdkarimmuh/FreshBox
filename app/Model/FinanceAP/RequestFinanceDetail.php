<?php

namespace App\Model\FinanceAP;

use App\Model\MasterData\Uom;
use Illuminate\Database\Eloquent\Model;

class RequestFinanceDetail extends Model
{
    protected $table = 'finance_request_detail';
    protected $fillable = ['request_finance_id', 'item_name', 'skuid', 'qty', 'uom_id', 'price', 'ppn', 'pph', 'total', 'supplier_name', 'remarks', 'price_confirm', 'total_confirm', 'qty_confirm', 'checked', 'created_at', 'updated_at'];
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
