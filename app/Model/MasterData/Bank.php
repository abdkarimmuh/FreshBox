<?php

namespace App\Model\MasterData;

use App\MyModel;
use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\Model;

class Bank extends MyModel
{
    use SearchTraits;

    protected $table = 'master_bank';

    protected $appends = [
        'created_by_name',
        'updated_by_name'
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
        'kode_bank' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_at' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_at' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'updated_at' => [
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

    public function getColumns()
    {
        return $this->columns;
    }
}
