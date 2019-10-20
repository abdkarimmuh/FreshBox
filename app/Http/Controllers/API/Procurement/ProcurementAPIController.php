<?php

namespace App\Http\Controllers\API\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Resources\Procurement\ListProcurementResource;
use App\Model\Marketing\SalesOrderDetail;
use App\Model\Procurement\AssignProcurement;
use App\Model\Procurement\ListProcurement;
use App\Model\Procurement\ListProcurementDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcurementAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = ListProcurement::all();

        return ListProcurementResource::collection($query);
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

        $rules = [
            'vendor' => 'required',
            'total_amount' => 'required|not_in:0',
            'payment' => 'required',
            // 'file' => 'required',
            'items' => 'required',
            'items.*.assign_proc_id' => 'required',
            'items.*.qty' => 'required|not_in:0',
            'items.*.uom_id' => 'required',
            'items.*.amount' => 'required',
        ];
        $request->validate($rules);

        $user_proc_id = auth('api')->user()->id;
        $vendor = $request->vendor;
        $total_amount = $request->total_amount;
        $payment = $request->payment;
        $items = $request->items;

        if ($request->file) {
            $file = $request->file;
            @list($type, $file_data) = explode(';', $file);
            @list(, $file_data) = explode(',', $file_data);
            $file_name = $this->generateProcOrderNo().'.'.explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            Storage::disk('local')->put('public/files/'.$file_name, base64_decode($file_data), 'public');
        } else {
            $file_name = '';
        }

        $procurement = ListProcurement::create([
            'procurement_no' => $this->generateProcOrderNo(),
            'user_proc_id' => $user_proc_id,
            'vendor' => $vendor,
            'total_amount' => $total_amount,
            'payment' => $payment,
            'file' => $file_name,
            'status' => 1,
            'created_by' => $user_proc_id,
            'created_at' => Carbon::now(),
        ]);

        foreach ($items as $item) {
            $listProcDetails[] = [
                'trx_list_procurement_id' => $procurement->id,
                'trx_assign_procurement_id' => $item['assign_proc_id'],
                'qty' => $item['qty'],
                'uom_id' => $item['uom_id'],
                'amount' => $item['amount'],
                'created_by' => $user_proc_id,
                'created_at' => Carbon::now(),
            ];
        }

        ListProcurementDetail::insert($listProcDetails);

        return response()->json([
            'status' => 'success',
            'data' => $procurement,
            'detail' => $listProcDetails,
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

    public function generateProcOrderNo()
    {
        $year_month = Carbon::now()->format('ym');
        $latest_proc = ListProcurement::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        $get_last_proc_no = isset($latest_proc->procurement_no) ? $latest_proc->procurement_no : 'PROC'.$year_month.'00000';
        $cut_string_proc = str_replace('PROC', '', $get_last_proc_no);

        return 'PROC'.($cut_string_proc + 1);
    }

    // public function storeWarehouseIn(Request $request)
    // {
    //     $rules = [
    //         'vendor' => 'required',
    //         'total_amount' => 'required|not_in:0',
    //         'payment' => 'required',
    //         // 'file' => 'required',
    //         'items' => 'required',
    //         'items.*.assign_proc_id' => 'required',
    //         'items.*.qty' => 'required|not_in:0',
    //         'items.*.uom_id' => 'required',
    //         'items.*.amount' => 'required',
    //     ];
    //     $request->validate($rules);

    //     $user_proc_id = auth('api')->user()->id;
    //     $vendor = $request->vendor;
    //     $total_amount = $request->total_amount;
    //     $payment = $request->payment;
    //     $items = $request->items;

    //     if ($request->file) {
    //         $file = $request->file;
    //         @list($type, $file_data) = explode(';', $file);
    //         @list(, $file_data) = explode(',', $file_data);
    //         $file_name = $this->generateProcOrderNo().'.'.explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
    //         Storage::disk('local')->put('public/files/'.$file_name, base64_decode($file_data), 'public');
    //     } else {
    //         $file_name = '';
    //     }

    //     $procurement = ListProcurement::create([
    //         'procurement_no' => $this->generateProcOrderNo(),
    //         'user_proc_id' => $user_proc_id,
    //         'vendor' => $vendor,
    //         'total_amount' => $total_amount,
    //         'payment' => $payment,
    //         'file' => $file_name,
    //         'status' => 1,
    //         'created_by' => $user_proc_id,
    //         'created_at' => Carbon::now(),
    //     ]);

    //     foreach ($items as $item) {
    //         $listProcDetails[] = [
    //             'trx_list_procurement_id' => $procurement->id,
    //             'trx_assign_procurement_id' => $item['assign_proc_id'],
    //             'qty' => $item['qty'],
    //             'uom_id' => $item['uom_id'],
    //             'amount' => $item['amount'],
    //             'created_by' => $user_proc_id,
    //             'created_at' => Carbon::now(),
    //         ];

    //         $assignProcurement = AssignProcurement::where('id', $item['assign_proc_id'])->first();
    //         $salesOrderDetail = SalesOrderDetail::where('id', $assignProcurement['sales_order_detail_id'])->first();

    //         $salesOrderDetail->sisa_qty_proc = $salesOrderDetail->sisa_qty_proc - $item['qty'];
    //         $salesOrderDetail->save();
    //     }

    //     ListProcurementDetail::insert($listProcDetails);

    //     return response()->json([
    //         'status' => 'success',
    //     ]);
    // }
}
