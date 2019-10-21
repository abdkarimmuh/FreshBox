<?php

namespace App\Model\Procurement;

use App\MyModel;
use App\Traits\SearchTraits;

class ListProcurement extends MyModel
{
    use SearchTraits;

    protected $table = 'trx_list_procurement';
    protected $fillable = ['procurement_no', 'user_proc_id', 'vendor', 'total_amount', 'payment', 'file', 'status', 'created_by', 'created_at'];

    protected $appends = [
        'created_by_name',
        'updated_by_name',
        'proc_name',
        'status_name',
    ];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'procurement_no' => [
            'searchable' => true,
            'search_relation' => true,
        ],
        'proc_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'UserProc',
            'relation_field' => 'proc_name',
        ],
        'vendor' => [
            'searchable' => true,
            'search_relation' => true,
        ],
        'total_amount' => [
            'searchable' => true,
            'search_relation' => true,
        ],
        'payment' => [
            'searchable' => true,
            'search_relation' => true,
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

    public function getStatusNameAttribute()
    {
        if ($this->status === 1) {
            return '<span class="badge badge-info">Submit</span>';
        } elseif ($this->status === 2) {
            return '<span class="badge badge-success">Receive</span>';
        } elseif ($this->status === 3) {
            return '<span class="badge badge-danger">Return</span>';
        } else {
            return 'Status NotFound';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
