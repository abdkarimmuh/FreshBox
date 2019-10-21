<?php

namespace App\Http\Controllers\API\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Resources\Procurement\AssignProcurementResource;
use App\Model\Marketing\SalesOrder;
use App\Model\Marketing\SalesOrderDetail;
use App\Model\Procurement\AssignProcurement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ItemProcurementAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = AssignProcurement::all();

        return AssignProcurementResource::collection($query);
    }

    public function indexAPI()
    {
        $query = AssignProcurement::where('user_proc_id', auth('api')->user()->id)->get();

        return AssignProcurementResource::collection($query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'items' => 'required',
            'items.*.skuid' => 'required',
            'items.*.pick' => 'required',
            'items.*.uom_id' => 'required',
        ];
        $request->validate(array_merge($rules));

        $user_proc_id = auth('api')->user()->id;
        $items = $request->items;

        foreach ($items as $item) {
            $skuid = $item['skuid'];
            $qty_all = number_format($item['pick']);
            $uom_id = $item['uom_id'];

            $sales_order_detail = SalesOrderDetail::where('status', 1)->where('skuid', $skuid)->where('uom_id', $uom_id)->get();

            $count = 0;

            foreach ($sales_order_detail as $data) {
                $sales_order = SalesOrder::find($data->sales_order_id);

                if ($qty_all >= $data->sisa_qty_proc) {
                    $data->sisa_qty_proc = 0;
                    $qty_all = $qty_all - $data->qty;
                    $sales_order->status = 2;

                    $count = $count + $data->qty;
                } else {
                    $data->sisa_qty_proc = $data->sisa_qty_proc - $qty_all;
                    $count = $count + $qty_all;

                    $qty_all = 0;
                    $sales_order->status = 1;
                }

                $data->status = 2;
                $data->save();
                $sales_order->save();

                if ($qty_all == 0) {
                    break;
                }
            }

            if ($count != 0) {
                DB::select('call insert_assign_procurement(?, ?, ?, ?, ?)', array($skuid, $user_proc_id, $count, $uom_id, $user_proc_id));

                return response()->json([
                    'status' => 'success',
                ]);
            } else {
                return response()->json([
                    'status' => 'error',
                ]);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
