<?php

namespace App;

use App\Traits\LaravelVueDatatableTrait;
use Illuminate\Database\Eloquent\Model;

class Testing extends Model
{
    use LaravelVueDatatableTrait;
    protected $table = 'projects';
    protected $dataTableColumns = [
        'id_penjaminan' => [
            'searchable' => false,
        ],
        'thn_ijp' => [
            'searchable' => true,
        ],
        'ijp' => [
            'searchable' => true,
        ],
        'tgl_produksi' => [
            'searchable' => true,
        ]
    ];

}
