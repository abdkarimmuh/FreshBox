<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderResource;
use App\Model\Marketing\SalesOrder;

class FormSalesOrderAPIController extends Controller
{
    public function index()
    {
        return SalesOrderResource::collection(SalesOrder::where('status', 1)->get());
    }

    public function show($id)
    {
        $sales_order = new SalesOrderResource(SalesOrder::findOrFail($id));

        return response()->json(
            [
                'data' =>  $sales_order,
            ],
            200
        );
    }
}
