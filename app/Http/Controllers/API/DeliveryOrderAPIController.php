<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\Warehouse\DeliveryOrderResource;
use App\Model\Warehouse\DeliveryOrder;

class DeliveryOrderAPIController extends Controller
{
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
