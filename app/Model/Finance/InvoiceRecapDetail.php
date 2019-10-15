<?php

namespace App\Model\Finance;

use Illuminate\Database\Eloquent\Model;

class InvoiceRecapDetail extends Model
{
    protected $table = 'trx_invoice_recap_detail';

    protected $fillable = ['invoice_recap_id','invoice_id'];

    public function recap_invoice()
    {
        return $this->belongsTo(InvoiceRecap::class);
    }
}