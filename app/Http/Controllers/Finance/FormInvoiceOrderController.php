<?php

namespace App\Http\Controllers\Finance;

use App\Http\Resources\Warehouse\DeliveryOrderResource;
use App\Model\Finance\InvoiceOrder;
use App\Model\Marketing\SalesOrder;
use App\Model\Warehouse\DeliveryOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use function foo\func;

class FormInvoiceOrderController extends Controller
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
            array('title' => 'Invoice Order No', 'field' => 'invoice_no'),
            array('title' => 'Delivery Order No', 'field' => 'delivery_order_no'),
            array('title' => 'Sales Order No', 'field' => 'sales_order_no'),
            array('title' => 'Customer', 'field' => 'customer_name'),
            array('title' => 'Invoice Date', 'field' => 'invoice_date'),
            array('title' => 'Total Amount', 'field' => 'total_amount'),
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
            array('title' => 'Status', 'field' => 'status_name'),
        ];

        $config = [
            //Title Required
            'title' => 'List Invoice Order',
            //Search Route Required
            'route-search' => 'admin.marketing.sales_order.index',
            /**
             * Route Can Be Null, Using Route Name
             */
            //Route For Button Add
            'route-add' => 'admin.finance.invoice_order.create',
            //Route For Button View
            'route-view' => 'admin.finance.invoice_order.show',
        ];

        $query = InvoiceOrder::dataTableQuery($searchValue);
        $data = $query->paginate(10);

        return view('admin.crud.index', compact('columns', 'data', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        if ($request->ajax()) {
            $delivery_order = DeliveryOrder::whereHas('sales_order', function ($q) {
                $q->where('status', 5);
            })->get();
            return DeliveryOrderResource::collection($delivery_order);
        }
        $config = [
            'vue-component' => '<add-invoice></add-invoice>'
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
        $rules = [
            'invoice_date' => 'required',
            'do_id' => 'required',
        ];

        $request->validate($rules);

        $dt = Carbon::now();
        $year_month = $dt->format('ym');
        //Untuk Mendapatkan Data Terakhir Invoice Order di Bulan Tahun Berjalan
        $latest_invoice_order = InvoiceOrder::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        //Cek jika ada data sales order maka di ambil invoice_no
        //Kalau Tidak ada maka di buat invoice_no baru
        $get_last_inv_no = isset($latest_invoice_order->invoice_no) ? $latest_invoice_order->invoice_no : 'INV' . $year_month . '00000';
        //Mereplace Text INV ke String Kosong
        $cut_string_inv_no = str_replace("INV", "", $get_last_inv_no);
        //Hasil Akhir Delivery Order No
        $invoice_order_no = 'INV' . ($cut_string_inv_no + 1);

        $so_id = $request->so_id;
        $invoice_order = [
            'do_id' => $request->do_id,
            'user_id' => $request->user_id,
            'invoice_date' => $request->invoice_date,
            'invoice_no' => $invoice_order_no,
            'created_by' => $request->user_id
        ];
        InvoiceOrder::create($invoice_order);
        SalesOrder::find($so_id)->update(['status' => 6]);
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
