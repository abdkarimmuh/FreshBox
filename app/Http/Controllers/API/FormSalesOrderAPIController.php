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
        return SalesOrder::where('status', 1)->get();
    }

    public function show($id)
    {
        return new SalesOrderResource(SalesOrder::findOrFail($id));
    }
}
