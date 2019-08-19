<?php

namespace App\Http\Controllers\Marketing;

use App\Model\Marketing\SalesOrder;
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

        $query = SalesOrder::dataTableQuery($column, $orderBy, $searchValue);
        $data = $query->paginate(5);

        return new DataTableCollectionResource($data);
    }
}
