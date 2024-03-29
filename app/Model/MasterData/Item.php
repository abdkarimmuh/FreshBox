<?php

namespace App\Model\MasterData;

use App\MyModel;
use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends MyModel
{
    use SearchTraits;
    use SoftDeletes;

    protected $table = 'master_item';
    protected $fillable = ['skuid','name_item','uom_id','origin_id','category_id','created_by'];

    protected $appends = [
        'created_by_name',
        'updated_by_name',
        'category_name',
        'uom_name',
        'origin_code',
        'tax_percentage',
        'skuid_item_name',
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
        'category_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Category',
            'relation_field' => 'name',
        ],
        'uom_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Uom',
            'relation_field' => 'name',
        ],
        'tax' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'origin_code' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Origin',
            'relation_field' => 'origin_code',
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

    public function Category()
    {
        return $this->belongsTo(Category::class);
    }

    public function getSkuidItemNameAttribute()
    {
        return $this->skuid.' - '.$this->name_item;
    }

    public function getCategoryNameAttribute()
    {
        if (isset($this->Category->name)) {
            return $this->Category->name;
        } else {
            return '';
        }
    }

    public function getTaxPercentageAttribute()
    {
        if (isset($this->tax)) {
            return $this->tax.'%';
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
