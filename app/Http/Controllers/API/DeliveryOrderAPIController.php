<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\SalesOrderResource;
use App\Model\Marketing\SalesOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Warehouse\DeliveryOrderResource;
use App\Model\Warehouse\DeliveryOrder;

class DeliveryOrderAPIController extends Controller
{

    public function create()
    {
        return SalesOrderResource::collection(SalesOrder::where('status', 2)->get());
    }
    public function show($id)
    {
        $delivery_order = DeliveryOrder::where('id', $id)
            ->whereHas('sales_order', function ($q) {
                $q->where('status', 4);
            })->first();

        //        return $delivery_order;

        return  new DeliveryOrderResource($delivery_order);
    }
}
