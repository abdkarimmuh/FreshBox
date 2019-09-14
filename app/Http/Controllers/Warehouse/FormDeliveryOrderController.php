<?php

namespace App\Http\Controllers\Warehouse;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Warehouse\DeliveryOrder;

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
            //Route For Button Edit
            'route-edit' => 'admin.marketing.sales_order.edit',
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
        return view('admin.warehouse.create_delivery_order');
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
        // $request->validate(array_merge($validation_po, $rules));

        $dt = Carbon::now();
        $year_month = $dt->format('ym');
        //Untuk Mendapatkan Data Terakhir Sales Order di Bulan Tahun Berjalan
        $latest_delivery_order = DeliveryOrder::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        //Cek jika ada data sales order maka di ambil sales_order_no
        //Kalau Tidak ada maka di buat sales_order_no baru
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
        $sales_order = SalesOrder::create([
            'delivery_order_no' => $delivery_order_no,
            'sales_order_id' => $sales_order_id,
            'customer_id' => $customer_id,
            'do_date' => $do_date,
            'driver_id' => $driver_id,
            'remark' => $remark,
            'created_by' => $user,
        ]);
        SalesOrder::find($sales_order_id)->update(['status' => 2]);

        //Untuk Menggabungkan Sales Order Details Menjadi Data Array
        foreach ($so_details as $i => $detail) {
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

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
