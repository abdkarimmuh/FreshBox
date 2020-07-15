<?php

namespace App\Model\Finance;

use App\Model\MasterData\Customer;
use App\MyModel;
use Illuminate\Database\Eloquent\Model;

class InvoiceRecap extends MyModel
{
    protected $table = 'trx_invoice_recap';
    protected $fillable = ['customer_id', 'recap_invoice_no', 'recap_date', 'created_by', 'submitted_date', 'paid_date','file'];
    protected $dates = ['recap_date', 'submitted_date','paid_date'];
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
        return $query->whereNull('paid_date');
    }

    public function scopeIsPaid($query)
    {
        return $query->whereNotNull('paid_date');
    }

    public function scopeIsSubmitted($query)
    {
        return $query->whereNotNull('submitted_date');
    }

    public function scopeIsNotSubmitted($query)
    {
        return $query->whereNull('submitted_date');
    }

    public function getCustomerNameAttribute()
    {
        // return $this->customer->name;
        if (isset($this->customer->name)) {
            return $this->customer->name;
        } else {
            return '';
        }
    }
}
