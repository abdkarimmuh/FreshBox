<?php

namespace App\Model\FinanceAP;

use App\MyModel;
use App\Traits\SearchTraits;
use App\UserProc;

class TopUpProc extends MyModel
{
    use SearchTraits;

    protected $table = 'trx_topup_proc';
    protected $fillable = ['user_proc_id', 'amount', 'status', 'remark', 'created_by'];
    protected $appends = [
        'user_name',
        'status_name',
        'date',
    ];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'user_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'UserProc.User',
            'relation_field' => 'name',
        ],
        'amount' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_at' => [
            'searchable' => true,
            'search_relation' => false,
        ],
        'created_by_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'create_by',
            'relation_field' => 'name',
        ],
    ];

    public function UserProc()
    {
        return $this->belongsTo(UserProc::class, 'user_proc_id', 'id');
    }

    public function getUserNameAttribute()
    {
        return $this->UserProc->User->name;
    }

    public function getStatusNameAttribute()
    {
        if ($this->status === 1) {
            return '<span class="badge badge-light">Submit</span>';
        } elseif ($this->status === 2) {
            return '<span class="badge badge-primary">Approve</span>';
        } elseif ($this->status === 3) {
            return '<span class="badge badge-danger">Reject</span>';
        } else {
            return 'Status NotFound';
        }
    }

    public function getDateAttribute()
    {
        return $this->created_at->formatLocalized('%d-%B-%Y');
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
