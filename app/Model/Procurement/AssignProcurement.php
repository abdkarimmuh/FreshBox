<?php

namespace App\Model\Procurement;

use App\Model\MasterData\Item;
use App\Model\MasterData\Uom;
use App\MyModel;
use App\Traits\SearchTraits;

class AssignProcurement extends MyModel
{
    use SearchTraits;

    protected $table = 'trx_assign_procurement';
    protected $fillable = ['skuid', 'user_proc_id', 'created_by'];

    protected $appends = [
        'created_by_name',
        'updated_by_name',
        'proc_name',
        'item_name',
        'uom',
    ];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'skuid' => [
            'searchable' => true,
            'search_relation' => true,
        ],
        'item_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Item',
            'relation_field' => 'item_name',
        ],
        'qty' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'uom' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'Uom',
            'relation_field' => 'uom',
        ],
        'proc_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'UserProc',
            'relation_field' => 'proc_name',
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

    public function UserProc()
    {
        return $this->belongsTo(UserProcurement::class);
    }

    public function getProcNameAttribute()
    {
        if (isset($this->UserProc->User->name)) {
            return $this->UserProc->User->name;
        } else {
            return '';
        }
    }

    public function Item()
    {
        return $this->belongsTo(Item::class);
    }

    public function getItemNameAttribute()
    {
        if (isset($this->item->name_item)) {
            return $this->item->name_item;
        } else {
            return '';
        }
    }

    public function Uom()
    {
        return $this->belongsTo(Uom::class);
    }

    public function getUomAttribute()
    {
        if (isset($this->Uom->name)) {
            return $this->Uom->name;
        } else {
            return '';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
