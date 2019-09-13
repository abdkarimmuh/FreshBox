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
        // $request->validate(array_merge($validation_po, $rules));

        $dt = Carbon::now();
        $year_month = $dt->format('ym');
        //Untuk Mendapatkan Data Terakhir Sales Order di Bulan Tahun Berjalan
        $latest_sales_order = SalesOrder::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        //Cek jika ada data sales order maka di ambil sales_order_no
        //Kalau Tidak ada maka di buat sales_order_no baru
        $get_last_so_no = isset($latest_sales_order->sales_order_no) ? $latest_sales_order->sales_order_no : 'SO' . $year_month . '00000';
        //Mereplace Text SO ke String Kosong
        $cut_string_so = str_replace("SO", "", $get_last_so_no);
        //Menjumlahkan
        $sum_so_no = $cut_string_so + 1;
        //Hasil Akhir Sales Order No
        $sales_order_no = 'SO' . $sum_so_no;


        $customer_id = $request->customerId;
        $items = $request->items;
        $source_order_id = $request->sourceOrderId;
        $fulfillment_date = $request->fulfillmentDate;
        $remarks = $request->remark;
        $user = $request->user_id;

        //Untuk Mengupload File Ke Storage
        if ($request->file) {
            $file = $request->file;
            @list($type, $file_data) = explode(';', $file);
            @list(, $file_data) = explode(',', $file_data);
            $file_name = $sales_order_no . '-' . time() . '-' . $source_order_id . '.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            Storage::disk('local')->put('public/files/' . $file_name, base64_decode($file_data), 'public');
        } else {
            $file_name = '';
        }

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
        $customer_id = $request->customerId;
        $remarks = $request->remark;
        $sales_order_id = $request->salesOrderId;
        $items = $request->items;
        $user = 1;

        /**
         * Proses Update Data Order Details
         */
        SalesOrder::where('id', $sales_order_id)->update(['remarks' => $remarks]);

        $collection = collect($items);
        //Filter Data Untuk Di Update
        $FilterHasOrderDetailsID = $collection->filter(function ($value, $key) {
            if (isset($value['qty']) && isset($value['order_details_id'])) {
                return true;
            }
        });
        //Mengambil List Order Details ID Yang Sudah Di Filter
        $OnlyOrderDetailsID = $FilterHasOrderDetailsID->pluck('order_details_id')->all();

        $OrderDetailsIDStr = implode(',', $OnlyOrderDetailsID);

        $OrderDetailLists = SalesOrderDetail::whereIn('id', $OnlyOrderDetailsID)
            ->orderByRaw(DB::raw("FIND_IN_SET(id, '$OrderDetailsIDStr')"))
            ->get();

        foreach ($FilterHasOrderDetailsID as $i => $row) {
            SalesOrderDetail::where('id', $row['order_details_id'])
                ->update([
                    'qty' => $row['qty'],
                    'amount_price' => $OrderDetailLists[$i]->amount_price,
                    'total_amount' => $OrderDetailLists[$i]->amount_price * $row['qty'],
                    'notes' => $row['notes'],
                    'updated_by' => $user
                ]);
        }

        /**
         * Proses Insert Baru Jika Ada Penambahan Items
         */

        //Untuk Memfilter Data Yang Baru Di Tambah
        $FilterWithoutOrderDetailsID = $collection->filter(function ($value, $key) use ($collection) {
            if (isset($value['qty']) && !isset($value['order_details_id'])) {
                return true;
            }
        });
        if (isset($FilterWithoutOrderDetailsID)) {
            //Merapihkan Posisi Index Data Yang Baru Di Tambah
            foreach ($FilterWithoutOrderDetailsID as $row) {
                $withoutOrderDetailsID[] = [
                    'sales_order_id' => $sales_order_id,
                    'skuid' => $row['skuid'],
                    'qty' => $row['qty'],
                    'notes' => $row['notes'],
                    'created_by' => $user
                ];
            }
            if (isset($withoutOrderDetailsID)) {
                //Memindahkan Ke Collection
                $withoutOrderDetailsID = collect($withoutOrderDetailsID);
                //Mengambil Semua SKUID Data Yang Baru di Tambah
                $OnlySKUIDs = $withoutOrderDetailsID->pluck('skuid')->all();
                //Merubah Array SKUID ke String
                $OnlySKUIDStr = implode(',', $OnlySKUIDs);
                //Mengambil List Data Di Table Price
                //Untuk Perhitungan Total Amount Via Backend
                $PriceLists = Price::where('customer_id', $customer_id)
                    ->whereIn('skuid', $OnlySKUIDs)
                    ->orderByRaw(DB::raw("FIND_IN_SET(skuid, '$OnlySKUIDStr')"))
                    ->get();

                //Merapihkan Posisi Index Data Yang Baru Di Tambah
                foreach ($withoutOrderDetailsID as $i => $row) {
                    $FinalWithoutOrderDetailsID[] = [
                        'sales_order_id' => $sales_order_id,
                        'skuid' => $row['skuid'],
                        'qty' => $row['qty'],
                        'amount_price' => $PriceLists[$i]->amount,
                        'total_amount' => $PriceLists[$i]->amount * $row['qty'],
                        'uom_id' => $PriceLists[$i]->uom_id,
                        'notes' => $row['notes'],
                        'created_by' => $user

                    ];
                }
                SalesOrderDetail::insert($FinalWithoutOrderDetailsID);
            }
        }
        return response()->json([
            'status' => 'success'
        ], 200);
    }

    public function DownloadFile($file)
    {
        return Storage::download('public/files/' . $file);
    }
}
