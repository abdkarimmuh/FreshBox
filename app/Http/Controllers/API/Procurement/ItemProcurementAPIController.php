<?php

namespace App\Http\Controllers\API\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Resources\Procurement\AssignProcurementResource;
use App\Model\Marketing\SalesOrder;
use App\Model\Marketing\SalesOrderDetail;
use App\Model\Procurement\AssignProcurement;
use Carbon\Carbon;
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
        $query = AssignProcurement::where('user_proc_id', auth('api')->user()->id)
        ->whereHas('SalesOrderDetail', function ($query) {
            $query->where('status', '<=', 2);
        })->get();

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
            'items' => 'required',
            'items.*.skuid' => 'required',
            'items.*.pick' => 'required',
            'items.*.uom_id' => 'required',
        ];
        $request->validate(array_merge($rules));

        $user_proc_id = auth('api')->user()->id;
        $items = $request->items;

        foreach ($items as $item) {
            // return $item;

            $skuid = $item['skuid'];
            $qty_all = number_format($item['pick']);
            $uom_id = $item['uom_id'];

            DB::select('call insert_assign_procurement(?, ?, ?, ?, ?)', array($skuid, auth()->user()->id, $qty_all, $uom_id, Carbon::now()));

            //Untuk Melakukan assign procurement
            // $assign_procurement[] = [
            //     'sales_order_detail_id' => $data->id,
            //     'user_proc_id' => $user_proc_id,
            //     'qty' => $qty_proc,
            //     'uom_id' => $data->uom_id,
            //     'created_by' => $user_proc_id,
            //     'created_at' => Carbon::now(),
            // ];

            // AssignProcurement::insert($assign_procurement);

            $sales_order_detail = SalesOrderDetail::where('status', 1)->where('skuid', $skuid)->where('uom_id', $uom_id)->get();

            foreach ($sales_order_detail as $data) {
                $sales_order = SalesOrder::find($data->sales_order_id);
                $sales_order->status = 2;

                if ($qty_all >= $data->sisa_qty_proc) {
                    $data->sisa_qty_proc = 0;
                    $qty_all = $qty_all - $data->qty;
                } else {
                    $data->sisa_qty_proc = $data->sisa_qty_proc - $qty_all;
                    $qty_all = 0;
                }

                $data->status = 2;
                $data->save();
                $sales_order->save();

                if ($qty_all == 0) {
                    break;
                }
            }
        }

        return response()->json([
            'status' => 'success',
            // 'data' => $assign_procurement
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
