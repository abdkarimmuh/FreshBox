<?php

namespace App\Model\MasterData;

use App\MyModel;
use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\SoftDeletes;

class Residence extends MyModel
{
    use SearchTraits;
    use SoftDeletes;

    protected $table = 'master_residence';

    protected $appends = [
        'created_by_name',
        'updated_by_name',
        'province_name',
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
        'province_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Province',
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

    public function getColumns()
    {
        return $this->columns;
    }
}
