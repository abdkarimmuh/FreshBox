<?php

namespace App\Model\Finance;

use App\Model\MasterData\Customer;
use Illuminate\Database\Eloquent\Model;

class InvoiceRecap extends Model
{
    protected $table = 'trx_invoice_recap';
    protected $fillable = ['customer_id', 'recap_invoice_no', 'recap_date', 'created_by'];

    public function invoice_recap_detail()
    {
        return $this->hasMany(InvoiceRecapDetail::class, 'invoice_recap_id', 'id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeIsNotPaid($query)
    {
        return $query->where('is_paid', 0);
    }

    public function scopeIsPaid($query)
    {
        return $query->where('is_paid', 1);
    }
}
