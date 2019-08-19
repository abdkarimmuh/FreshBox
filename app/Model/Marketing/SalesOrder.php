<?php

namespace App\Model\Marketing;

use App\Traits\LaravelVueDatatableTrait;
use Illuminate\Database\Eloquent\Model;

class SalesOrder extends Model
{
    use LaravelVueDatatableTrait;

    protected $table = 'trxsalesorder';
    protected $primaryKey = 'ID';
    protected $appends = [
        'view_route',
        'edit_route',
        'delete_route'
    ];

    protected $dataTableColumns = [
        'ID' => [
            'searchable' => false,
        ],
        'SalesorderNo' => [
            'searchable' => true,
        ],
        'IDCust' => [
            'searchable' => true,
        ],
        'SourceID' => [
            'searchable' => true,
        ],
        'FullFillmentDate' => [
            'searchable' => true,
        ],
        'Remarks' => [
            'searchable' => true,
        ],
        'CreatedDate' => [
            'searchable' => true,
        ],
        'CreatedUser' => [
            'searchable' => true,
        ],
        'ModifiedDate' => [
            'searchable' => true,
        ],
        'Modifieduser' => [
            'searchable' => true,
        ],
        'DOStatus' => [
            'searchable' => true,
        ],
        'SOStatus' => [
            'searchable' => true,
        ],
    ];

    function getEditRouteAttribute(){
        return 'editSalesOrder';
    }
    function getViewRouteAttribute(){
        return 'viewSalesOrder';
    }
    function getDeleteRouteAttribute(){
        return 'deleteSalesOrder';
    }
}
