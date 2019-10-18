<?php

namespace App\Http\Controllers\API\Warehouse;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfirmDeliveryOrderAPIController extends Controller
{
    public function index()
    {
        $searchValue = $request->input('search');
        $query = DeliveryOrder::whereHas('sales_order', function ($q) {
            $q->where('status', 4);
        })->dataTableQuery($searchValue);
        $data = $query->paginate(10);

    }
}
