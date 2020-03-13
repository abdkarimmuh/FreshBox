<?php

namespace App\Http\Controllers\ApiV1\WarehouseOut;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Model\Marketing\SalesOrder;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\DeliveryOrder;
use App\Http\Resources\SalesOrderResource;
use App\Model\Warehouse\DeliveryOrderDetail;
use App\Http\Resources\CreateDeliveryOrderResource;
use App\Http\Resources\Warehouse\DeliveryOrderResource;

class DeliveryOrderAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;
        $query = DeliveryOrder::dataTableQuery($searchValue);
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
     *  Show the form for creating a new resource.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function create()
    {
        return CreateDeliveryOrderResource::collection(SalesOrder::where('status', '<=',  3)->orderBy('sales_order_no','desc')
                    ->get());
    }


    /**
     * Show the specified resource.
     * @param Request $request
     * @return DeliveryOrderResource|\Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function show(Request $request)
    {
        $id = $request->id;

        if (is_array($id)) {
            $do = DeliveryOrder::whereIn('id', $id)->orderBy('delivery_order_no', 'desc')->get();
            return DeliveryOrderResource::collection($do);
        } else {
            $do = DeliveryOrder::findOrFail($id);
            return new DeliveryOrderResource($do);
        }
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        //List Validasi
        $rules = [
            'sales_order_id' => 'required|not_in:0|unique:trx_delivery_order',
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

        SalesOrder::find($data['sales_order_id'])->update(['status' => 4]);

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    /**
     * @return string
     */
    public function generateDeliveryOrderNo()
    {
        $year_month = Carbon::now()->format('ym');
        $latest_delivery_order = DeliveryOrder::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        $get_last_do_no = isset($latest_delivery_order->delivery_order_no) ? $latest_delivery_order->delivery_order_no : 'DO' . $year_month . '00000';
        $cut_string_do = str_replace('DO', '', $get_last_do_no);

        return 'DO' . ($cut_string_do + 1);
    }

}
