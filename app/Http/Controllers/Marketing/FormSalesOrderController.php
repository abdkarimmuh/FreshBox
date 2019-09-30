<?php

namespace App\Http\Controllers\Marketing;

use App\Model\Marketing\SalesOrder;
use App\Model\Marketing\SalesOrderDetail;
use App\Model\MasterData\Price;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\MasterData\PriceResource;
use App\Http\Resources\SalesOrderResource;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class FormSalesOrderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $searchValue = $request->input('query');
            $perPage = $request->perPage;
            $query = SalesOrder::dataTableQuery($searchValue);
            if ($request->start && $request->end) {
                $query->whereBetween('sales_order_no', [$request->start, $request->end]);
            }
            if ($searchValue) {
                $query = $query->take(20)->paginate(20);
            } else {
                $query = $query->paginate($perPage);
            }
            $data = SalesOrderResource::collection($query);
            return $data;
        }
//        return view
//        $columns = [
//            array('title' => 'Sales Order No', 'field' => 'sales_order_no'),
//            array('title' => 'Customer', 'field' => 'customer_name'),
//            array('title' => 'Source Order', 'field' => 'source_order_name'),
//            array('title' => 'NO PO', 'field' => 'no_po'),
//            array('title' => 'Fulfillment Date', 'field' => 'fulfillment_date'),
//            array('title' => 'Remarks', 'field' => 'remarks'),
//            array('title' => 'Status', 'field' => 'status_name', 'type' => 'html'),
//            array('title' => 'Created By', 'field' => 'created_by_name'),
//            array('title' => 'Created At', 'field' => 'created_at'),
//        ];
//
//        $config = [
//            'base_url' => 'form_sales_order',
//            'title' => 'Form Sales Order',
//            'route_search' => 'admin.marketing.sales_order.index',
//            'route_add' => 'form_sales_order/create',
//            'route_edit' => 'admin.marketing.sales_order.edit',
//            'route_view' => 'form_sales_order/',
//            'url_multiple_print' => 'form_sales_order/multiplePrint',
//
//        ];
//
//        $config = json_encode($config);
//        $columns = json_encode($columns);
//
        $config = [
            'vue-component' => "<router-view></router-view>"
        ];
        return view('layouts.vue-view', compact('config'));
    }

    public function create()
    {
        $config = [
            'vue-component' => "<router-view></router-view>"
        ];
        return view('layouts.vue-view', compact('config'));
    }

    public function edit($id, Request $request)
    {
        $sales_order = new SalesOrderResource(SalesOrder::findOrFail($id));

        if ($request->ajax()) {
            $price = Price::where('customer_id', $sales_order->customer_id)->get();
            if (isset($price)) {
                $price = PriceResource::collection($price);
            } else {
                $price = 'empty';
            }

            return response()->json([
                'data' => $sales_order,
                'items' => $price
            ], 200);
        }
        $config = [
            'vue-component' => "<router-view></router-view>"
        ];
        return view('layouts.vue-view', compact('config'));
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
        $request->validate(array_merge($validation_po, $rules));


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
        //Insert Data Array Sales Order Details
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

    public function generateSalesOrderNo()
    {
        $year_month = Carbon::now()->format('ym');
        $latest_sales_order = SalesOrder::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        $get_last_so_no = isset($latest_sales_order->sales_order_no) ? $latest_sales_order->sales_order_no : 'SO' . $year_month . '00000';
        $cut_string_so = str_replace("SO", "", $get_last_so_no);
        return 'SO' . ($cut_string_so + 1);
    }

    public function DownloadFile($file)
    {
        return Storage::download('public/files/' . $file);
    }

    public function deleteOrderDetails($id)
    {
        $so_detail = SalesOrderDetail::find($id);
        $so_detail->delete();

        return response()->json([
            'status' => 'Success!'
        ], 200);
    }

    public function multiplePrint(Request $request)
    {
        if ($request->id) {
            $id = $request->id;
            if ($request->ajax()) {
                if ($request->isMethod('POST')) {
                    SalesOrder::whereIn('id', $id)->update(['is_printed' => 1]);
                } else {
                    $sales_order = SalesOrderResource::collection(SalesOrder::whereIn('id', $id)->get());
                    return response()->json($sales_order, 200);
                }
            }
            $config = [
                'vue-component' => "<router-view></router-view>"
            ];
            return view('layouts.vue-view', compact('config'));
        } else {
            return back();
        }
    }

    public function print($id)
    {
        if (request()->ajax()) {
            if (request()->isMethod('POST')) {
                SalesOrder::where('id', $id)->update(['is_printed' => 1]);
            } else {
                $sales_order = new SalesOrderResource(SalesOrder::findOrFail($id));
                return response()->json($sales_order, 200);
            }
        }
        $config = [
            'vue-component' => "<router-view></router-view>"
        ];
        return view('layouts.vue-view', compact('config'));
    }

    public function paginate($items, $perPage = 15, $page = null, $options = [])
    {
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }


}
