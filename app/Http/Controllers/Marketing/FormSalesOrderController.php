<?php

namespace App\Http\Controllers\Marketing;

use App\Http\Requests\SalesOrderAddRequest;
use App\Model\Marketing\SalesOrder;
use App\Model\Marketing\SalesOrderDetail;
use App\Model\MasterData\Item;
use App\Model\MasterData\Price;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class FormSalesOrderController extends Controller
{
    public function index(Request $request)
    {
        $searchValue = $request->input('search');
        $columns = [
            array('title' => 'Sales Order No', 'field' => 'sales_order_no'),
            array('title' => 'Customer', 'field' => 'customer_name'),
            array('title' => 'Source Order', 'field' => 'source_order_name'),
            array('title' => 'NO PO', 'field' => 'no_po'),
            array('title' => 'Fulfillment Date', 'field' => 'fulfillment_date'),
            array('title' => 'Remarks', 'field' => 'remarks'),
            array('title' => 'File', 'field' => 'file'),
            array('title' => 'Status', 'field' => 'status_name'),
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
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

    public function InsertSalesOrderDetail(Request $request)
    {
        //Check Jika Source Order PO
        //Maka No PO Wajib Di Isi
        //Jika Source Order ! = PO Maka No PO = ''
        if ($request->sourceOrderId === 1) {
            $validation_po = ['no_po' => 'required'];
            $no_po = $request->no_po;
        } else {
            $validation_po = [];
            $no_po = '';
        }
        //List Validasi
        $rules = [
            'fulfillmentDate' => 'required',
            'customerId' => 'required|not_in:0',
            'sourceOrderId' => 'required',
            'file' => 'required|file64:jpeg,jpg,png,pdf',
            'items' => 'required',
            'items.*.qty' => 'required|not_in:0',

        ];
        //Validasi Inputan
        $request->validate(array_merge($validation_po, $rules));

        $dt = Carbon::now();
        $year_month = $dt->format('ym');
        $latest_sales_order = SalesOrder::latest()->first();
        $last_number = isset($latest_sales_order->id) ? $latest_sales_order->id : 0;
        $number = $last_number + 1;
        $sales_order_no = 'SO' . $year_month . '0000' . $number;

        $customer_id = $request->customerId;
        $items = $request->items;
        $source_order_id = $request->sourceOrderId;
        $fulfillment_date = $request->fulfillmentDate;
        $remarks = $request->remark;
        $user = $request->user_id;

        //Untuk Mengupload File Ke Storage
        $file = $request->file;
        @list($type, $file_data) = explode(';', $file);
        @list(, $file_data) = explode(',', $file_data);
        $file_name = $sales_order_no . '-' . time() . '-' . $source_order_id . '.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
        Storage::disk('local')->put('public/files/' . $file_name, base64_decode($file_data), 'public');

        //Untuk Menginput Sales Order
        $sales_order = SalesOrder::create([
            'sales_order_no' => $sales_order_no,
            'customer_id' => $customer_id,
            'source_order_id' => $source_order_id,
            'fulfillment_date' => $fulfillment_date,
            'no_po' => $no_po,
            'remarks' => $remarks,
            'file' => $file_name,
            'status' => 1,
            'created_by' => $user,
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
        //Untuk Memunculkan Data Price Dengan List SKUID
        $listItems = Price::whereIn('skuid', $skuids)
            ->where('customer_id', $customer_id)
            ->orderByRaw(DB::raw("FIND_IN_SET(skuid, '$skuidsStr')"))
            ->get();
        //Untuk Menggabungkan Sales Order Details Menjadi Data Array
        foreach ($items as $i => $detail) {
            if (isset($detail['qty'])) {
                $salesOrderDetails[] = [
                    'sales_order_id' => $sales_order->id,
                    'skuid' => $detail['skuid'],
                    'uom_id' => $listItems[$i]->uom_id,
                    'qty' => $detail['qty'],
                    'amount_price' => $listItems[$i]->amount,
                    'total_amount' => $listItems[$i]->amount * $detail['qty'],
                    'notes' => $detail['notes'],
                    'created_by' => $user,
                ];
            } else {
                unset($items[$i]);
            }
        }
        //Untuk Menginput Data Array Sales Order Details
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

    public function DownloadFile($file)
    {
        return Storage::download('public/files/' . $file);
    }
}
