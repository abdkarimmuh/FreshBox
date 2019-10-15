<?php

namespace App\Model\Finance;

use App\Model\MasterData\Customer;
use Illuminate\Database\Eloquent\Model;

class RecapInvoice extends Model
{
    protected $table = 'trx_invoice_recap';
    protected $fillable = ['customer_id', 'recap_invoice_no', 'recap_date', 'created_by'];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
