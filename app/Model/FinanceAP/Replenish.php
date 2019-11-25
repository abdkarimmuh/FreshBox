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

    public function procurement()
    {
        return $this->belongsTo(ListProcurement::class, 'list_proc_id', 'id');
    }


    function getStatusHtmlAttribute()
    {
        if ($this->status === 1) {
            return '<span class="badge badge-success">Replenish</span>';
        } elseif ($this->status === 2) {
            return '<span class="badge badge-danger">Return Replenish</span>';
        } else {
            return 'Status NotFound';
        }
    }
}
