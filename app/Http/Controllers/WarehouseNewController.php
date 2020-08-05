<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\Warehouse\DeliveryOrder;
use App\Http\Resources\Warehouse\DeliveryOrderResource;

class WarehouseNewController extends Controller
{
    public function index(Request $request)
    {
       
        $data =  DeliveryOrder::whereHas('sales_order', function ($q) {
            $q->where('status', 4);
        })->paginate(10);

        $finalData = DeliveryOrderResource::collection($data);
    }
}
