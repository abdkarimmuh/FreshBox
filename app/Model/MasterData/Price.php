<?php

namespace App\Model\MasterData;

use App\MyModel;
use App\Traits\SearchTraits;
use App\User;
use Illuminate\Database\Eloquent\Model;
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
        'uom_name'
    ];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'skuid' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'item_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Item',
            'relation_field' => 'name_item'
        ],
        'uom_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Uom',
            'relation_field' => 'name'
        ],
        'customer_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Customer',
            'relation_field' => 'name'
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
            'relation_field' => 'name'
        ],
        'updated_by_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'update_by',
            'relation_field' => 'name'
        ]
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
}
