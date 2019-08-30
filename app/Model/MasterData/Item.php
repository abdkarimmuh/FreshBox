<?php

namespace App\Model\MasterData;

use App\MyModel;
use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends MyModel
{
    use SearchTraits;
    use SoftDeletes;

    protected $table = 'master_item';

    protected $appends = [
        'created_by_name',
        'updated_by_name',
        'category_name',
        'uom_name',
        'origin_code'
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
        'name_item' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'name_item_latin' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'is_trf_item' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'description' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'category' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Category',
            'relation_field' => 'name'
        ],
        'uom' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Uom',
            'relation_field' => 'name'
        ],
        'origin' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Origin',
            'relation_field' => 'name'
        ],
        'created_at' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_by' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_by_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'create_by',
            'relation_field' => 'name'
        ]
    ];

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getCategoryNameAttribute()
    {
        if (isset($this->Category->name)) {
            return $this->Category->name;
        } else {
            return '';
        }
    }

    public function Uom()
    {
        return $this->belongsTo(Uom::class);
    }

    public function getUomNameAttribute()
    {
        if (isset($this->Uom->name)) {
            return $this->Uom->name;
        } else {
            return '';
        }
    }

    public function Origin()
    {
        return $this->belongsTo(Origin::class);
    }

    public function getOriginCodeAttribute()
    {
        if (isset($this->Origin->origin_code)) {
            return $this->Origin->origin_code;
        } else {
            return '';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
