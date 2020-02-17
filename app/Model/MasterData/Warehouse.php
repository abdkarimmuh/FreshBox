<?php

namespace App\Model\MasterData;

use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\Model;

class Warehouse extends Model
{
    use SearchTraits;

    protected $table = 'master_warehouse';
    protected $fillable = ['name', 'address', 'created_at', 'updated_at'];
    protected $appends = ['created_at_name', 'updated_at_name'];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'name' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'address' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_at' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'updated_at' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'created_at_name' => [
            'searchable' => true,
            'search_relation' => false,
        ],
    ];

    public function getCreatedAtNameAttribute()
    {
        return isset($this->created_at) ? $this->created_at->formatLocalized('%d %B %Y') : '';
    }

    public function getUpdatedAtNameAttribute()
    {
        return isset($this->updated_at) ? $this->updated_at->formatLocalized('%d %B %Y') : '';
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
