<?php

namespace App\Model\Finance;

use App\Model\MasterData\Customer;
use Illuminate\Database\Eloquent\Model;

class InvoiceRecap extends Model
{
    protected $table = 'trx_invoice_recap';
    protected $fillable = ['customer_id', 'recap_invoice_no', 'recap_date', 'created_by'];
    protected $dates = ['recap_date'];
    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'recap_invoice_no' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'customer_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Customer',
            'relation_field' => 'name',
        ],
        'created_at' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_by' => [
            'searchable' => true,
            'search_relation' => false,
        ]
    ];

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

    public function scopeIsSubmitted($query)
    {
        return $query->whereNotNull('submitted_date');
    }

    public function getCustomerNameAttribute()
    {
        return $this->customer->name;
    }
}
