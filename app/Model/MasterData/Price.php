<?php

namespace App\Model\MasterData;

use App\MyModel;
use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\SoftDeletes;

class Price extends MyModel
{
    use SearchTraits;
    use SoftDeletes;

    protected $table = 'master_price';

    protected $appends = [
        'created_by_name',
        'updated_by_name',
        'item_name',
        'uom_name',
        'customer_name',
    ];
    protected $fillable = [
        'skuid',
        'uom_id',
        'customer_id',
        'amount_basic',
        'amount_discount',
        'amount',
        'tax_value',
        'start_periode',
        'end_periode',
        'created_by',
    ];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'skuid' => [
            'searchable' => true,
            'search_relation' => true,
        ],
        'item_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Item',
            'relation_field' => 'name_item',
        ],
        'uom_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Uom',
            'relation_field' => 'name',
        ],
        'customer_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Customer',
            'relation_field' => 'name',
        ],
        'amount' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'tax_value' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'start_periode' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'end_periode' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'remarks' => [
            'searchable' => false,
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
            'relation_field' => 'name',
        ],
        'updated_by_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'update_by',
            'relation_field' => 'name',
        ],
    ];

    public function Uom()
    {
        return $this->belongsTo(Uom::class);
    }

    public function Customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function Item()
    {
        return $this->belongsTo(Item::class, 'skuid', 'skuid');
    }

    public function getCustomerNameAttribute()
    {
        return $this->Customer->name;
    }

    public function getUomNameAttribute()
    {
        return $this->Uom->name;
    }

    public function getItemNameAttribute()
    {
        return $this->Item->name_item;
    }
}
