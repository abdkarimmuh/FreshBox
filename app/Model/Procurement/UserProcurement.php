<?php

namespace App\Model\Procurement;

use App\Model\MasterData\Bank;
use App\Model\MasterData\Category;
use App\Model\MasterData\Origin;
use App\MyModel;
use App\Traits\SearchTraits;
use App\User;

class UserProcurement extends MyModel
{
    use SearchTraits;

    protected $table = 'user_proc';

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
            'search_relation' => true,
            'relation_name' => 'User',
            'relation_field' => 'name'
        ],
        'email' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'User',
            'relation_field' => 'email'
        ],
        'bank_account' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'bank_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Bank',
            'relation_field' => 'name'
        ],
        'origin_code' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Origin',
            'relation_field' => 'origin_code'
        ],
        'category_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Category',
            'relation_field' => 'name'
        ],
        'saldo' => [
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

    public function User()
    {
        return $this->belongsTo(User::class);
    }

    public function getNameAttribute()
    {
        if (isset($this->User->name)) {
            return $this->User->name;
        } else {
            return '';
        }
    }

    public function getEmailAttribute()
    {
        if (isset($this->User->email)) {
            return $this->User->email;
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

    public function Origin()
    {
        return $this->belongsTo(Origin::class);
    }

    public function getOriginCodeAttribute()
    {
        if (isset($this->Origin->origin_code)) {
            return $this->Origin->origin_code;
        } else {
            return '';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}

