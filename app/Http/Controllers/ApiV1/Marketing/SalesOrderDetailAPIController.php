<?php

namespace App\Http\Controllers\ApiV1\Marketing;

use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderDetailResource;
use App\Model\Marketing\SalesOrderDetail;

class SalesOrderDetailAPIController extends Controller
{
    /**
     * Sales Order Detail Is Procurement.
     *
     * @return AnonymousResourceCollection
     */
    public function soDetailIsConfirm()
    {
        return SalesOrderDetailResource::collection(SalesOrderDetail::where('status', 4)->get());
    }

    /**
     * Sales Order Detail Is Procurement.
     *
     * @return AnonymousResourceCollection
     */
    public function show($id)
    {
        return SalesOrderDetailResource::collection(SalesOrderDetail::where('id', $id)->get())->first();
    }
}
