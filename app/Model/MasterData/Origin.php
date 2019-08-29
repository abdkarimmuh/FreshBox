<?php

namespace App\Model\MasterData;

use App\MyModel;
use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Origin extends MyModel
{
    use SearchTraits;
    use SoftDeletes;

    protected $table = 'master_origin';

    protected $appends = [
        'created_by_name',
        'updated_by_name'
    ];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'origin_code' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'description' => [
            'searchable' => true,
            'search_relation' => false,
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

    public function getColumns()
    {
        return $this->columns;
    }
}
