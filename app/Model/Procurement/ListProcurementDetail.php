<?php

namespace App\Model\Procurement;

use App\MyModel;
use App\Traits\SearchTraits;

class ListProcurementDetail extends MyModel
{
    use SearchTraits;

    protected $table = 'trx_list_procurement_detail';
}
