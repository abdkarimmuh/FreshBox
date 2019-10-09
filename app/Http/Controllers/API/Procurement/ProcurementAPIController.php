<?php

namespace App\Http\Controllers\API\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Resources\Procurement\ListProcurementResource;
use App\Model\Procurement\ListProcurement;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //List Validasi
        $rules = [
            'user_proc_id' => 'required',
            'vendor' => 'required',
            'total_amount' => 'required|not_in:0',
            'payment' => 'required',
            'item' => 'required',
            'items.*.qty' => 'required|not_in:0',
        ];
        $request->validate($rules);

        $customer_id = $request->customerId;
        $items = $request->items;
        $source_order_id = $request->sourceOrderId;
        $fulfillment_date = $request->fulfillmentDate;
        $remarks = $request->remark;
        $user = $request->user_id;
        $driver_id = $request->driver_id;

        //Untuk Mengupload File Ke Storage
        if ($request->file) {
            $file = $request->file;
            @list($type, $file_data) = explode(';', $file);
            @list(, $file_data) = explode(',', $file_data);
            $file_name = $this->generateSalesOrderNo() . '.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            Storage::disk('local')->put('public/files/' . $file_name, base64_decode($file_data), 'public');
        } else {
            $file_name = '';
        }

        //Untuk Menginput Sales Order
        $sales_order = SalesOrder::create([
            'sales_order_no' => $this->generateSalesOrderNo(),
            'customer_id' => $customer_id,
            'source_order_id' => $source_order_id,
            'fulfillment_date' => $fulfillment_date,
            'remarks' => $remarks,
            'file' => $file_name,
            'status' => 1,
            'driver_id' => $driver_id,
            'created_by' => $user,
            'created_at' => Carbon::now(),
        ]);
        //Untuk Mendapatkan List SKUID
        foreach ($items as $i => $detail) {
            if (isset($detail['qty'])) {
                $skuids[] = $detail['skuid'];
            } else {
                unset($items[$i]);
            }
        }
        $skuidsStr = implode(',', $skuids);
        $listItems = Price::whereIn('skuid', $skuids)
            ->where('customer_id', $customer_id)
            ->orderByRaw(DB::raw("FIND_IN_SET(skuid, '$skuidsStr')"))
            ->get();
        foreach ($items as $i => $detail) {
            if (isset($detail['qty'])) {
                $salesOrderDetails[] = [
                    'sales_order_id' => $sales_order->id,
                    'skuid' => $detail['skuid'],
                    'uom_id' => $listItems[$i]->uom_id,
                    'qty' => $detail['qty'],
                    'sisa_qty_proc' => $detail['qty'],
                    'amount_price' => $listItems[$i]->amount,
                    'total_amount' => $listItems[$i]->amount * $detail['qty'],
                    'notes' => $detail['notes'],
                    'status' => 1,
                    'created_by' => $user,
                ];
            } else {
                unset($items[$i]);
            }
        }
        //Insert Data Array Sales Order Details
        SalesOrderDetail::insert($salesOrderDetails);

        return response()->json([
            'status' => 'success'
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
