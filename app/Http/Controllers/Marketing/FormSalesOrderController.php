<?php

namespace App\Http\Controllers\Marketing;

use App\Model\Marketing\SalesOrder;
use App\Model\Marketing\SalesOrderDetail;
use App\Model\MasterData\Item;
use App\Model\MasterData\Price;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use JamesDordoy\LaravelVueDatatable\Http\Resources\DataTableCollectionResource;

class FormSalesOrderController extends Controller
{
    public function index(Request $request)
    {
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $orderBy = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $query = SalesOrder::dataTableQuery($column, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataTableCollectionResource($data);
    }

    public function show($id)
    {
        return SalesOrder::with('sales_order_details.item')->find($id);
    }

    public function InsertSalesOrderDetail(Request $request)
    {
        $customer_id = $request->customerId;
        $sales_order_no = $request->salesOrderNo;
        $source_order_id = $request->sourceOrder;
        $fulfillment_date = $request->fulfillmentDate;
        $remarks = $request->remark;
        $details = $request->details;
        $user = 1;
//
        $item = Price::where('customer_id', $customer_id)->get();

        $sales_order = SalesOrder::create([
            'sales_order_no' => $sales_order_no,
            'customer_id' => $customer_id,
            'source_order_id' => $source_order_id,
            'fulfillment_date' => $fulfillment_date,
            'remarks' => $remarks,
            'status' => 1,
            'created_by' => $user,
        ]);

//        foreach ($request->details as  $detail) {
//            $salesOrderDetails[] = [
//                'skuid' => $detail->skuid,
//                'qty' => $detail->qty,
//                'notes' => $detail->notes,
//            ];
//        }

        for ($i = 0; $i < count($details); $i++) {
            $salesOrderDetails[] = [
                'sales_order_id' => $sales_order->id,
                'skuid' => $details[$i]['skuid'],
                'uom_id' => $item[$i]->uom_id,
                'qty' => $details[$i]['qty'],
                'amount_price' => $item[$i]->amount,
                'total_amount' => $item[$i]->amount * $details[$i]['qty'],
                'notes' => $details[$i]['notes'],
                'created_by' => $user,
            ];
        }

        SalesOrderDetail::insert($salesOrderDetails);
        return response()->json(['sales_order_id' => $salesOrderDetails], 200);
    }
}
