<?php

namespace App\Model\MasterData;

use App\MyModel;
use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends MyModel
{
    use SearchTraits;
    use SoftDeletes;

    protected $table = 'master_vendor';

    protected $appends = [
        'created_by_name',
        'updated_by_name',
        'category_name',
        'bank_name'
    ];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'name' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'category_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Category',
            'relation_field' => 'name'
        ],
        'bank_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Bank',
            'relation_field' => 'name'
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

    public function Bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function getBankNameAttribute()
    {
        if (isset($this->Bank->name)) {
            return $this->Bank->name;
        } else {
            return '';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
