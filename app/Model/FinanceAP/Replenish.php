<?php

namespace App\Model\FinanceAP;

use App\Model\Procurement\ListProcurement;
use App\MyModel;
use App\Traits\SearchTraits;

class Replenish extends MyModel
{
    use SearchTraits;
    protected $table = 'trx_replenish';
    protected $fillable = ['status', 'total_amount', 'list_proc_id', 'remark', 'created_by'];

    protected $columns = [
        'id' => [
            'searchable' => false,
            'search_relation' => false,
        ],
        'procurement_no' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'procurement',
            'relation_field' => 'name',
        ],
        'user_procurement' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'procurement.UserProc.User',
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

    public function procurement()
    {
        return $this->belongsTo(ListProcurement::class, 'list_proc_id', 'id');
    }

    public function getStatusHtmlAttribute()
    {
        if ($this->status === 1) {
            return '<span class="badge badge-success">Replenish</span>';
        } elseif ($this->status === 2) {
            return '<span class="badge badge-danger">Return Replenish</span>';
        } elseif ($this->status === 3) {
            return '<span class="badge badge-warning">Update Document</span>';
        } else {
            return 'Status NotFound';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
