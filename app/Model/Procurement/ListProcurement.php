<?php

namespace App\Model\Procurement;

use App\Model\FinanceAP\Replenish;
use App\MyModel;
use App\Traits\SearchTraits;

class ListProcurement extends MyModel
{
    use SearchTraits;

    protected $table = 'trx_list_procurement';
    protected $fillable = ['procurement_no', 'user_proc_id', 'vendor', 'total_amount', 'payment', 'file', 'status', 'remarks', 'created_by', 'created_at'];
    protected $appends = [
        'created_by_name',
        'updated_by_name',
        'proc_name',
        'status_name',
        'items',
    ];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'procurement_no' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'proc_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'UserProc.User',
            'relation_field' => 'name',
        ],
        'vendor' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'payment' => [
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
    ];

    public function UserProc()
    {
        return $this->belongsTo(UserProcurement::class);
    }

    public function ListProcurementDetail()
    {
        return $this->hasMany(ListProcurementDetail::class, 'trx_list_procurement_id', 'id');
    }

    public function Replenish()
    {
        return $this->hasMany(Replenish::class, 'list_proc_id', 'id');
    }

    public function getItemsAttribute()
    {
        return $this->ListProcurementDetail;
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
        if ($this->status == 1) {
            return '<span class="badge badge-info">Submit</span>';
        } elseif ($this->status == 2) {
            return '<span class="badge badge-success">Receive</span>';
        } elseif ($this->status == 3) {
            return '<span class="badge badge-danger">Return</span>';
        } elseif ($this->status == 4) {
            return '<span class="badge badge-primary">Replenish</span>';
        } elseif ($this->status == 5) {
            return '<span class="badge badge-dark">Return Replenish</span>';
        } elseif ($this->status == 6) {
            return '<span class="badge badge-secondary">Action Return Item</span>';
        } elseif ($this->status == 7) {
            return '<span class="badge badge-secondary">Action Return Fund</span>';
        } else {
            return 'Status NotFound';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
