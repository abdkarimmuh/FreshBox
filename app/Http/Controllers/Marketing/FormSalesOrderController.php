<?php

namespace App\Http\Controllers\Marketing;

use App\Model\Marketing\SalesOrder;
use App\Model\Marketing\SalesOrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class FormSalesOrderController extends Controller
{
    public function index(Request $request)
    {
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $orderBy = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $query = SalesOrder::dataTableQuery($column, $orderBy, $searchValue)->whereNull('created_at');
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    public function sales_order_detail($customer_id)
    {
        return SalesOrderDetail::where('customer_id', $customer_id)->get();
    }
}
