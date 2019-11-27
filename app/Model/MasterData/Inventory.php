<?php

namespace App\Model\MasterData;

use App\MyModel;
use App\Traits\SearchTraits;

class Inventory extends MyModel
{
    use SearchTraits;

    protected $table = 'master_inventory';
    protected $fillable = ['skuid', 'qty', 'created_by', 'updated_by'];

    protected $appends = [
        'item_name',
        'uom_name',
        'created_by_name',
        'updated_by_name',
    ];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'skuid' => [
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
            'relation_field' => 'name',
        ],
        'updated_by_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'update_by',
            'relation_field' => 'name',
        ],
    ];

    public function Item()
    {
        return $this->belongsTo(Item::class, 'skuid', 'skuid');
    }

    public function getItemNameAttribute()
    {
        return $this->Item->name_item;
    }

    public function getUomNameAttribute()
    {
        return $this->Item->uom_name;
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
