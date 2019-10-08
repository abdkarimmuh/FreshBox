<?php

namespace App\Model\MasterData;

use App\MyModel;
use App\Traits\DriverTrait;
use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\SoftDeletes;

class Driver extends MyModel
{
    use SearchTraits;
    use SoftDeletes;
    use DriverTrait;

    protected $table = 'master_driver';

    protected $appends = [
        'created_by_name',
        'updated_by_name',
        'role_name'
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
        'phone_number' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'vehicle_no' => [
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

    public function getColumns()
    {
        return $this->columns;
    }
}
