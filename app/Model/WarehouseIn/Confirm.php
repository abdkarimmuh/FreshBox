<?php

namespace App\Model\WarehouseIn;

use App\Model\Procurement\ListProcurement;
use App\MyModel;
use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\SoftDeletes;

class Confirm extends MyModel
{
    use SearchTraits;
    use SoftDeletes;

    protected $table = 'trx_warehouse_confirm';
    protected $fillable = ['list_procurement_id', 'remark', 'status', 'created_by', 'created_at'];
    protected $appends = [
        'procurement_no',
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
            'relation_name' => 'ListProcurement',
            'relation_field' => 'procurement_no',
        ],
        'proc_name' => [
            'searchable' => true,
            'search_relation' => true,
            'relation_name' => 'ListProcurement',
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

    public function ListProcurement()
    {
        return $this->belongsTo(ListProcurement::class, 'list_procurement_id', 'id');
    }

    public function ConfirmDetail()
    {
        return $this->hasMany(ConfirmDetail::class, 'warehouse_confirm_id', 'id');
    }

    public function getProcurementNoAttribute()
    {
        if (isset($this->ListProcurement->procurement_no)) {
            return $this->ListProcurement->procurement_no;
        } else {
            return '';
        }
    }

    public function getProcNameAttribute()
    {
        if (isset($this->ListProcurement->UserProc->User->name)) {
            return $this->ListProcurement->UserProc->User->name;
        } else {
            return '';
        }
    }

    public function getStatusNameAttribute()
    {
        if ($this->status == 1) {
            return '<span class="badge badge-info">Receive</span>';
        } elseif ($this->status == 2) {
            return '<span class="badge badge-danger">Return</span>';
        } elseif ($this->status == 3) {
            return '<span class="badge badge-success">Payment</span>';
        } else {
            return 'Status NotFound';
        }
    }

    public function getColumns()
    {
        return $this->columns;
    }
}
