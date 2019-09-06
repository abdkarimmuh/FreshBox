<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Requests\SalesOrderAddRequest;
use App\Model\Marketing\SalesOrder;
use App\Model\Marketing\SalesOrderDetail;
use App\Model\MasterData\Item;
use App\Model\MasterData\Price;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FormSalesOrderController extends Controller
{
    public function index(Request $request)
    {
//        $length = $request->input('length');
//        $column = $request->input('column'); //Index
//        $orderBy = $request->input('dir', 'asc');
        $searchValue = $request->input('search');


        $columns = [
            array('title' => 'Sales Order No', 'field' => 'sales_order_no'),
            array('title' => 'Customer', 'field' => 'customer_name'),
            array('title' => 'Source Order', 'field' => 'source_order_name'),
            array('title' => 'Fulfillment Date', 'field' => 'fulfillment_date'),
            array('title' => 'Remarks', 'field' => 'remarks'),
            array('title' => 'Status', 'field' => 'status_name'),
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
//            array('title' => 'Source Order', 'field' => 'source_order_name'),

        ];

        $config = [
            //Title Required
            'title' => 'Form Sales Order',
            //Search Route Required
            'route-search' => 'admin.marketing.sales_order.index',
            /**
             * Route Can Be Null, Using Route Name
             */
            //Route For Button Add
            'route-add' => 'admin.marketing.sales_order.create',
            //Route For Button Edit
            'route-edit' => 'admin.marketing.sales_order.edit',
            //Route For Button View
            'route-view' => 'testing.create',
        ];

        $query = SalesOrder::dataTableQuery($searchValue);
        $data = $query->paginate(10);

        return view('admin.crud.index', compact('columns', 'data', 'config'));
    }

    public function create()
    {

        return view('admin.marketing.sales_order.create');
    }

    public function edit($id)
    {
        $sales_order = SalesOrder::with('sales_order_details')->find($id);
        $sales_order_details = SalesOrderDetail::with('item')->where('sales_order_id', $id)->get();

        return view('admin.marketing.sales_order.edit', compact('sales_order', 'sales_order_details'));
    }

    public function show($id)
    {
        return SalesOrder::with('sales_order_details.item')->find($id);
    }

    public function InsertSalesOrderDetail(SalesOrderAddRequest $request)
    {
        $request->all();

        $dt = Carbon::now();
        $year_month = $dt->format('ym');

        $latest_sales_order = SalesOrder::latest()->first();
        $last_number = isset($latest_sales_order->id) ? $latest_sales_order->id : 0;
        $number = $last_number + 1;

        $customer_id = $request->customerId;
        $sales_order_no = 'SO' . $year_month . '0000' . $number;
        $source_order_id = $request->sourceOrderId;
        $fulfillment_date = $request->fulfillmentDate;
        $remarks = $request->remark;
        $items = $request->items;
        $no_po = isset($request->noPO) ? $request->noPO : '';

        $user = 1;

        $item = Price::where('customer_id', $customer_id)->get();

        $sales_order = SalesOrder::create([
            'sales_order_no' => $sales_order_no,
            'customer_id' => $customer_id,
            'source_order_id' => $source_order_id,
            'fulfillment_date' => $fulfillment_date,
            'no_po' => $no_po,
            'remarks' => $remarks,
            'status' => 1,
            'created_by' => $user,
        ]);

        foreach ($items as $i => $detail) {
            if (isset($detail['qty'])) {
                $salesOrderDetails[] = [
                    'sales_order_id' => $sales_order->id,
                    'skuid' => $detail['skuid'],
                    'uom_id' => $item[$i]->uom_id,
                    'qty' => $detail['qty'],
                    'amount_price' => $item[$i]->amount,
                    'total_amount' => $item[$i]->amount * $detail['qty'],
                    'notes' => $detail['notes'],
                    'created_by' => $user,
                ];
            } else {
                unset($items[$i]);
            }

        }
        SalesOrderDetail::insert($salesOrderDetails);

        return response()->json($sales_order);
    }

    public function getSalesOrderDetails($id)
    {
        return SalesOrderDetail::with('item')->where('sales_order_id', $id)->get();
    }

    public function updateSalesOrderDetails(Request $request)
    {
//        return $request->all();

        $dt = Carbon::now();
        $year_month = $dt->format('ym');

        $latest_sales_order = SalesOrder::latest()->first();
        $last_number = isset($latest_sales_order->id) ? $latest_sales_order->id : 0;
        $number = $last_number + 1;

        $customer_id = $request->customerId;
        $sales_order_id = $request->salesOrderId;

        $sales_order_no = 'SO' . $year_month . '0000' . $number;
        $source_order_id = $request->sourceOrderId;
        $fulfillment_date = $request->fulfillmentDate;
        $remarks = $request->remark;
        $items = $request->items;
        $no_po = isset($request->noPO) ? $request->noPO : '';
//
//        $user = 1;
//
//        $item = Price::where('customer_id', $customer_id)->get();
//

        $collection = collect($items);
        $hasOrderDetailsID = $collection->filter(function ($value, $key) {
            if (isset($value['qty']) && isset($value['order_details_id'])) {
                return true;
            }
        });
        $OnlyOrderDetailsID = $hasOrderDetailsID->pluck('order_details_id')->all();

        $FilterWithoutOrderDetailsID = $collection->filter(function ($value, $key) use ($collection) {
            if (isset($value['qty']) && !isset($value['order_details_id'])) {
                return true;
            }
        });


        foreach ($FilterWithoutOrderDetailsID as $row) {
            $withoutOrderDetailsID[] = [
                'sales_order_id' => $sales_order_id,
                'skuid' => $row['skuid'],
                'qty' => $row['qty'],
                'notes' => $row['notes'],
            ];
        }
        return $withoutOrderDetailsID;

//        foreach ($items as $i => $detail) {
//            if (isset($detail['qty']) && isset($detail['order_details_id'])) {
//                $order_details_id[] =
//                    $detail['order_details_id'];
//                $salesOrderDetails[] = [
//                    'sales_order_id' => $sales_order_id,
//                    'skuid' => $detail['skuid'],
//                    'qty' => $detail['qty'],
////                    'amount_price' => $item[$i]->amount,
////                    'total_amount' => $item[$i]->amount * $detail['qty'],
//                    'notes' => $detail['notes'],
//                ];
//            } else {
//                $insertSalesOrderDetails[] = [
//                    'sales_order_id' => $sales_order_id,
//                    'skuid' => $detail['skuid'],
//                    'qty' => $detail['qty'],
////                    'amount_price' => $item[$i]->amount,
////                    'total_amount' => $item[$i]->amount * $detail['qty'],
//                    'notes' => $detail['notes'],
//                ];
//            }
//
//        }

        return $order_details_id;
        SalesOrderDetail::insert($salesOrderDetails);

        return response()->json($sales_order);
    }
}
