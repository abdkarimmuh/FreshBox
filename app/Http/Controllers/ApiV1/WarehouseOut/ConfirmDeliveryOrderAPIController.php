<?php

namespace App\Http\Controllers\ApiV1\WarehouseOut;

use App\Http\Controllers\Controller;
use App\Http\Resources\Warehouse\DeliveryOrderResource;
use App\Model\Marketing\SalesOrder;
use App\Model\Warehouse\DeliveryOrder;
use App\Model\Warehouse\DeliveryOrderDetail;
use Illuminate\Http\Request;

class ConfirmDeliveryOrderAPIController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;
        $query = DeliveryOrder::whereHas('sales_order', function ($q) {
            $q->where('status', 4);
        })->dataTableQuery($searchValue);

        if ($request->start && $request->end) {
            $query->whereBetween('delivery_order_no', [$request->start, $request->end]);
        }
        if ($searchValue) {
            $query = $query->orderBy('delivery_order_no', 'desc')->take(20)->paginate(20);
        } else {
            $query = $query->orderBy('delivery_order_no', 'desc')->paginate($perPage);
        }

        return DeliveryOrderResource::collection($query);
    }

    /**
     * @param Request $request
     * @return DeliveryOrderResource
     */
    public function show(Request $request)
    {
        $delivery_order = DeliveryOrder::whereIn('id', $request->id)
            ->whereHas('sales_order', function ($q) {
                $q->where('status', 4);
            })->get();
        return new DeliveryOrderResource($delivery_order);
    }

    /**
     * @param Request $request
     */
    public function update(Request $request)
    {
        //List Validasi
        $rules = [
            'confirm_date' => 'required',
            'do_details.*.qty_confirm' => 'required',

        ];
        //Validasi Inputan
        $request->validate($rules);
        $do_id = $request->id;
        $confirm_date = $request->confirm_date;
        $so_id = $request->sales_order_id;
        $do_details = $request->do_details;

        //Update DO Details
        foreach ($do_details as $i => $detail) {
            DeliveryOrderDetail::where('id', $detail['id'])->update([
                'remark' => $detail['remark'],
                'qty_confirm' => $detail['qty_confirm'],
                'qty_minus' => $detail['qty_minus']
            ]);
        }
        $sales_order = SalesOrder::find($so_id);
        $sales_order->update([
            'status' => 5,
        ]);

        $delivery_order = DeliveryOrder::find($do_id);
        $delivery_order->update([
            'confirm_date' => $confirm_date,
        ]);
    }
}
