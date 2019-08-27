<?php

namespace App\Model\MasterData;

use App\Traits\LaravelVueDatatableTrait;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use LaravelVueDatatableTrait;
    use SoftDeletes;

    protected $table = 'master_category';

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
