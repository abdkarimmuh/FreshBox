<?php

namespace App\Http\Controllers\API\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Resources\Procurement\AssignProcurementResource;
use App\Http\Resources\SalesOrderDetailResource;
use App\Model\Marketing\SalesOrder;
use App\Model\Marketing\SalesOrderDetail;
use App\Model\Procurement\AssignProcurement;
use Carbon\Carbon;
use Illuminate\Http\Request;

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
        // return $request;
        //List Validasi
        $rules = [
            'skuid' => 'required',
            'user_proc_id' => 'required',
            'qty' => 'required|not_in:0',
            'uom_id' => 'required'
        ];
        $request->validate(array_merge($rules));

        $skuid = $request->skuid;
        $user_proc_id = $request->user_proc_id;
        $qty_all = number_format($request->qty);
        $uom_id = $request->uom_id;

        $sales_order_detail = SalesOrderDetail::where('status', 1)->where('skuid', $skuid)->where('uom_id', $uom_id)->orderBy('sales_order_id', 'desc')->get();

        foreach ($sales_order_detail as $item) {

            $sales_order = SalesOrder::find($item->sales_order_id);

            if ($qty_all >= $item->qty) {
                $item->status = 2;
                $item->sisa_qty_proc = 0;
                $qty_proc = $item->qty;

                $sales_order->status = 2;
                $qty_all = $qty_all - $item->qty;
            } else {
                $item->sisa_qty_proc = $qty_all;
                $qty_proc = $qty_all;

                $qty_all = 0;
            }

            $item->save();
            $sales_order->save();

            //Untuk Melakukan assign procurement
            $assign_procurement[] = [
                'sales_order_detail_id' => $item->id,
                'user_proc_id' => $user_proc_id,
                'qty' => $qty_proc,
                'uom_id' => $item->uom_id,
                'created_by' => $user_proc_id,
                'created_at' => Carbon::now(),
            ];

            if ($qty_all == 0) {
                break;
            }
        }

        AssignProcurement::insert($assign_procurement);

        return response()->json([
            'status' => 'success',
            'data' => $assign_procurement
        ]);
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
