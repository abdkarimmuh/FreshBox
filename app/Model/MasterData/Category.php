<?php

namespace App\Model\MasterData;

use App\MyModel;
use App\Traits\LaravelVueDatatableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends MyModel
{
    use LaravelVueDatatableTrait;
    use SoftDeletes;

    protected $table = 'master_category';
    protected $appends = [
        'created_by_name',
        'updated_by_name'
    ];

    protected $dataTableColumns = [
        'id' => [
            'searchable' => false,
        ],
        'name' => [
            'searchable' => true,
        ],
        'created_at' => [
            'searchable' => true,
        ],
        'created_by' => [
            'searchable' => true,
        ]
    ];
}
