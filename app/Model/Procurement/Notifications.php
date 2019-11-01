<?php

namespace App\Model\Procurement;

use App\Model\WarehouseIn\Confirm;
use App\MyModel;

class Notifications extends MyModel
{
    protected $table = 'notification_procurement';
    protected $fillable = ['status', 'message', 'user_proc_id', 'trx_warehouse_confirm_id', 'created_at'];
    protected $appends = [
        'procurement_no',
    ];

    public function UserProc()
    {
        return $this->belongsTo(UserProcurement::class, 'user_proc_id', 'id');
    }

    public function Confirm()
    {
        return $this->belongsTo(Confirm::class, 'trx_warehouse_confirm_id', 'id');
    }

    public function getProcurementNoAttribute()
    {
        if (isset($this->Confirm->ListProcturement->procurement_no)) {
            return $this->Confirm->ListProcturement->procurement_no;
        } else {
            return '';
        }
    }
}
