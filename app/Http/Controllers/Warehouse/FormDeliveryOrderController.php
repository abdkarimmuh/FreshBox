<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Resources\Warehouse\DeliveryOrderResource;
use App\Model\Warehouse\DeliveryOrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Marketing\SalesOrder;
use App\Model\Warehouse\DeliveryOrder;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class FormDeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $searchValue = $request->input('search');
        $columns = [
            array('title' => 'Delivery Order No', 'field' => 'delivery_order_no'),
            array('title' => 'Sales Order No', 'field' => 'sales_order_no'),
            array('title' => 'Customer', 'field' => 'customer_name'),
            array('title' => 'Do Date', 'field' => 'do_date'),
            array('title' => 'PIC QC', 'field' => 'pic_qc_name'),
            array('title' => 'Remarks', 'field' => 'remarks'),
            array('title' => 'Status', 'field' => 'status_name'),
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
        ];

        $config = [
            //Title Required
            'title' => 'Form Delivery Order',
            //Search Route Required
            'route-search' => 'admin.warehouse.delivery_order.index',
            /*
             * Route Can Be Null, Using Route Name
             */
            //Route For Button Add
            'route-add' => 'admin.warehouse.delivery_order.create',
            //Route For Button View
            'route-view' => 'admin.warehouse.delivery_order.print',
            'route-multiple-print' => 'admin.warehouse.delivery_order.multiplePrint',
        ];

        $query = DeliveryOrder::dataTableQuery($searchValue)->orderBy('delivery_order_no', 'desc');
        $data = $query->paginate(10);

        return view('admin.crud.index', compact('columns', 'data', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        $config = [
            'vue-component' => '<add-delivery-order></add-delivery-order>',
        ];

        return view('layouts.vue-view', compact('config'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        //List Validasi
        $rules = [
            'sales_order_id' => 'required|not_in:0',
            'customer_id' => 'required',
            'do_date' => 'required',
            'so_details.*.qty_do' => 'required|not_in:0',
            'pic_qc' => 'required',
        ];
        $request->validate($rules);

        $data = [
            'delivery_order_no' => $this->generateDeliveryOrderNo(),
            'sales_order_id' => $request->sales_order_id,
            'customer_id' => $request->customer_id,
            'do_date' => $request->do_date,
            'driver_id' => $request->driver_id,
            'remark' => $request->remark,
            'pic_qc' => $request->pic_qc,
            'created_by' => $request->user_id,
        ];
        $delivery_order = DeliveryOrder::create($data);
        SalesOrder::find($data['sales_order_id'])->update(['status' => 4]);

        $so_details = $request->so_details;
        foreach ($so_details as $i => $detail) {
            $salesOrderDetails[] = [
                'delivery_order_id' => $delivery_order->id,
                'sales_order_detail_id' => $detail['id'],
                'skuid' => $detail['skuid'],
                'uom_id' => $detail['uom_id'],
                'qty_do' => $detail['qty_do'],
                'created_by' => $data['created_by'],
            ];
        }
        DeliveryOrderDetail::insert($salesOrderDetails);

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * Generate Delivery Order No.
     *
     * @return string delivery order no
     */
    public function generateDeliveryOrderNo()
    {
        $year_month = Carbon::now()->format('ym');
        $latest_delivery_order = DeliveryOrder::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        $get_last_do_no = isset($latest_delivery_order->delivery_order_no) ? $latest_delivery_order->delivery_order_no : 'DO'.$year_month.'00000';
        $cut_string_do = str_replace('DO', '', $get_last_do_no);

        return 'DO'.($cut_string_do + 1);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return DeliveryOrderResource
     */
    public function show($id)
    {
        return new DeliveryOrderResource(DeliveryOrder::find($id));
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     *
     * @return View
     */
    public function print($id)
    {
        $config = [
            'vue-component' => "<print-delivery-order :id='$id'></print-delivery-order>",
        ];

        return view('layouts.vue-view', compact('config'));
    }

    public function multiplePrint(Request $request)
    {
        if ($request->id) {
            $id = $request->id;
            if ($request->ajax()) {
                $delivery_order = DeliveryOrderResource::collection(DeliveryOrder::whereIn('id', $id)->get());

                return response()->json($delivery_order, 200);
            }
            $config = [
                'vue-component' => " <multiple-print-delivery-order id='".json_encode($id)."'></multiple-print-delivery-order>",
            ];

            return view('layouts.vue-view', compact('config'));
        } else {
            return back();
        }
    }
}
