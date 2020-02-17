<?php

namespace App\Model\MasterData;

use App\MyModel;
use App\Traits\SearchTraits;

class BankAccout extends MyModel
{
    use SearchTraits;

    protected $table = 'master_bank_account';
    protected $fillable = ['name', 'bank_id', 'bank_account', 'created_by', 'updated_by'];
    protected $appends = ['bank_name'];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'name' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'bank_account' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'bank_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Bank',
            'relation_field' => 'name',
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
            'relation_field' => 'name',
        ],
        'updated_by_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'update_by',
            'relation_field' => 'name',
        ],
    ];

    public function Bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id', 'id');
    }

    public function getBankNameAttribute()
    {
        return $this->Bank->name;
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
