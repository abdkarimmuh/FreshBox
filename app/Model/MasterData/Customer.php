<?php

namespace App\Model\MasterData;

use App\Model\Finance\InvoiceOrder;
use App\MyModel;
use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends MyModel
{
    use SearchTraits;
    use SoftDeletes;

    protected $table = 'master_customer';

    protected $appends = [
        'created_by_name',
        'updated_by_name'
    ];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'customer_code' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'customer_type_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'CustomerType',
            'relation_field' => 'name'
        ],
        'customer_group_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'CustomerGroup',
            'relation_field' => 'name'
        ],
        'name' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'pic_customer' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'tlp_pic' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'address' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'province_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Province',
            'relation_field' => 'name'
        ],
        'residence_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Residence',
            'relation_field' => 'name'
        ],
        'kodepos' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_at' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_by_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'create_by',
            'relation_field' => 'name'
        ],
        'updated_by_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'update_by',
            'relation_field' => 'name'
        ]
    ];

    public function CustomerGroup()
    {
        return $this->belongsTo(CustomerGroup::class);
    }

    public function getCustomerGroupNameAttribute()
    {
        if (isset($this->CustomerGroup->name)) {
            return $this->CustomerGroup->name;
        } else {
            return '';
        }
    }

    public function CustomerType()
    {
        return $this->belongsTo(CustomerType::class);
    }

    public function getCustomerTypeNameAttribute()
    {
        if (isset($this->CustomerType->name)) {
            return $this->CustomerType->name;
        } else {
            return '';
        }
    }

    public function Province()
    {
        return $this->belongsTo(Province::class);
    }

    public function getProvinceNameAttribute()
    {
        if (isset($this->Province->name)) {
            return $this->Province->name;
        } else {
            return '';
        }
    }

    public function Residence()
    {
        return $this->belongsTo(Residence::class);
    }

    public function getResidenceNameAttribute()
    {
        if (isset($this->Residence->name)) {
            return $this->Residence->name;
        } else {
            return '';
        }
    }

    public function Price()
    {
        return $this->hasMany(Price::class);
    }

    public function Invoices()
    {
        return $this->hasMany(InvoiceOrder::class);
    }
    public function getColumns()
    {
        return $this->columns;
    }

}
