<?php

namespace App\Model\FinanceAP;

use App\Traits\SearchTraits;
use Illuminate\Database\Eloquent\Model;

class Replenish extends Model
{
    use SearchTraits;
    protected $table = 'trx_replenish';
    protected $fillable = ['status', 'total_amount', 'list_proc_id', 'remark','created_by'];
}
