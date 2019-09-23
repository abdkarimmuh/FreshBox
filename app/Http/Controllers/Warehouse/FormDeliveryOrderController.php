<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Resources\Warehouse\DeliveryOrderResource;
use App\Model\Warehouse\DeliveryOrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Marketing\SalesOrder;
use App\Model\Warehouse\DeliveryOrder;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class FormDeliveryOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $searchValue = $request->input('search');
        $columns = [
            array('title' => 'Delivery Order No', 'field' => 'delivery_order_no'),
            array('title' => 'Sales Order No', 'field' => 'sales_order_no'),
            array('title' => 'Customer', 'field' => 'customer_name'),
            array('title' => 'Do Date', 'field' => 'do_date'),
            array('title' => 'Remarks', 'field' => 'remarks'),
            array('title' => 'Status', 'field' => 'status_name'),
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
        ];

        $config = [
            //Title Required
            'title' => 'Form Delivery Order',
            //Search Route Required
            'route-search' => 'admin.marketing.sales_order.index',
            /**
             * Route Can Be Null, Using Route Name
             */
            //Route For Button Add
            'route-add' => 'admin.warehouse.delivery_order.create',
            //Route For Button View
            'route-view' => 'testing.create',
        ];

        $query = DeliveryOrder::dataTableQuery($searchValue);
        $data = $query->paginate(10);

        return view('admin.crud.index', compact('columns', 'data', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $config = [
            'vue-component' => "<add-delivery-order></add-delivery-order>"
        ];

        return view('layouts.vue-view', compact('config'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //List Validasi
        $rules = [
            'sales_order_id' => 'required|not_in:0',
            'customer_id' => 'required',
            'do_date' => 'required',
            'so_details.*.qty_do' => 'required|not_in:0',

        ];
        //Validasi Inputan
        $request->validate($rules);

        $dt = Carbon::now();
        $year_month = $dt->format('ym');
        //Untuk Mendapatkan Data Terakhir Delivery Order di Bulan Tahun Berjalan
        $latest_delivery_order = DeliveryOrder::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        //Cek jika ada data sales order maka di ambil delivery_order_no
        //Kalau Tidak ada maka di buat delivery_order_no baru
        $get_last_do_no = isset($latest_delivery_order->delivery_order_no) ? $latest_delivery_order->delivery_order_no : 'DO' . $year_month . '00000';
        //Mereplace Text DO ke String Kosong
        $cut_string_do = str_replace("DO", "", $get_last_do_no);
        //Menjumlahkan
        $sum_do_no = $cut_string_do + 1;
        //Hasil Akhir Delivery Order No
        $delivery_order_no = 'DO' . $sum_do_no;

        $user = $request->user_id;
        $sales_order_id = $request->sales_order_id;
        $customer_id = $request->customer_id;
        $do_date = $request->do_date;
        $driver_id = $request->driver_id;
        $remark = $request->remark;
        $so_details = $request->so_details;

        //Untuk Menginput Sales Order
        $delivery_order = DeliveryOrder::create([
            'delivery_order_no' => $delivery_order_no,
            'sales_order_id' => $sales_order_id,
            'customer_id' => $customer_id,
            'do_date' => $do_date,
            'driver_id' => $driver_id,
            'remark' => $remark,
            'created_by' => $user,
        ]);

        SalesOrder::find($sales_order_id)->update(['status' => 4]);

        $delivery_order_id = $delivery_order->id;


        //Untuk Menggabungkan Sales Order Details Menjadi Data Array
        foreach ($so_details as $i => $detail) {
            $salesOrderDetails[] = [
                'delivery_order_id' => $delivery_order_id,
                'sales_order_detail_id' => $detail['id'],
                'skuid' => $detail['skuid'],
                'uom_id' => $detail['uom_id'],
                'qty_do' => $detail['qty_do'],
                'created_by' => $user,
            ];
        }
        //Untuk Menginput Data Array Sales Order Details
        DeliveryOrderDetail::insert($salesOrderDetails);

        return response()->json($salesOrderDetails);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new DeliveryOrderResource(DeliveryOrder::find($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }
}
