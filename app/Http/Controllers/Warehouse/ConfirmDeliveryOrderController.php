<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Resources\Warehouse\DeliveryOrderDetailResource;
use App\Http\Resources\Warehouse\DeliveryOrderResource;
use App\Model\Warehouse\DeliveryOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Marketing\SalesOrder;
use App\Model\Warehouse\DeliveryOrderDetail;

class ConfirmDeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchValue = $request->input('search');

        $columns = [
            array('title' => 'Delivery Order No', 'field' => 'delivery_order_no'),
            array('title' => 'Sales Order No', 'field' => 'sales_order_no'),
            array('title' => 'Customer', 'field' => 'customer_name'),
            array('title' => 'Do Date', 'field' => 'do_date'),
            array('title' => 'Remarks', 'field' => 'remarks'),
            array('title' => 'Driver', 'field' => 'driver_name'),
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
        ];

        $config = [
            //Title Required
            'title' => 'Confirm Delivery Order',
            //Search Route Required
            'route-search' => 'admin.warehouse.confirm_delivery_order.index',
            /**
             * Route Can Be Null, Using Route Name
             */
            //Route For Button Confirm
            'route-confirm' => 'admin.warehouse.confirm_delivery_order.create',
        ];

        $query = DeliveryOrder::whereHas('sales_order', function ($q) {
            $q->where('status', 4);
        })->dataTableQuery($searchValue);
        $data = $query->paginate(10);

        return view('admin.crud.index', compact('columns', 'data', 'config'));
    }
//
//    /**
//     * Show the form for creating a new resource.
//     *
//     * @return DeliveryOrderResource
//     */
//    public function create($id)
//    {
//        if (request()->ajax()) {
//            $delivery_order = DeliveryOrder::where('id', $id)
//                ->whereHas('sales_order', function ($q) {
//                    $q->where('status', 4);
//                })->first();
//
//            return new DeliveryOrderResource($delivery_order);
//        }
//        $config = [
//            'vue-component' => "<confirm-delivery-order :do_id='" . $id . "'>" . "</confirm-delivery-order>"
//        ];
//        return view('layouts.vue-view', compact('config'));
//    }
//
//    /**
//     * Store a newly created resource in storage.
//     *
//     * @param \Illuminate\Http\Request $request
//     * @return \Illuminate\Http\Response
//     */
//    public function update(Request $request)
//    {
//        //List Validasi
//        $rules = [
//            'confirm_date' => 'required',
//            'do_details.*.qty_confirm' => 'required',
//
//        ];
//        //Validasi Inputan
//        $request->validate($rules);
//        $do_id = $request->id;
//        $confirm_date = $request->confirm_date;
//        $so_id = $request->sales_order_id;
//        $do_details = $request->do_details;
//
//        //Update DO Details
//        foreach ($do_details as $i => $detail) {
//            DeliveryOrderDetail::where('id', $detail['id'])->update([
//                'remark' => $detail['remark'],
//                'qty_confirm' => $detail['qty_confirm'],
//                'qty_minus' => $detail['qty_minus']
//            ]);
//        }
//
//        $sales_order = SalesOrder::find($so_id);
//        $sales_order->update([
//            'status' => 5,
//
//        ]);
//
//        $delivery_order = DeliveryOrder::find($do_id);
//        $delivery_order->update([
//            'confirm_date' => $confirm_date,
//        ]);
//    }
//
//    /**
//     * Display the specified resource.
//     *
//     * @param int $id
//     * @return \Illuminate\Http\Response
//     */
//    public function show($id)
//    {
//        //
//    }
}
