<?php

namespace App\Http\Controllers\ApiV1\WarehouseOut;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ConfirmDeliveryOrderAPIController extends Controller
{
    public function index(Request $request)
    {
        $searchValue = $request->input('search');
        return DeliveryOrder::whereHas('sales_order', function ($q) {
            $q->where('status', 4);
        })->dataTableQuery($searchValue)
            ->paginate(10);
    }
}
