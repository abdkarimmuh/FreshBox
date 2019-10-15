<?php

namespace App\Http\Controllers\Report;

use App\Http\Resources\Report\ReportSOResource;
use App\Model\Warehouse\DeliveryOrderDetail;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class reportSOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $searchValue = $request->input('search');

        $columns = [/*
            array('title' => 'No', 'field' => 'number'), */
            array('title' => 'Tanggal', 'field' => 'so_date'),
            array('title' => 'Customer', 'field' => 'customer_name'),
            array('title' => 'PO Customer No', 'field' => 'po_no'),
            array('title' => 'SO No', 'field' => 'sales_order_no'),
            array('title' => 'Category', 'field' => 'category_name'),
            array('title' => 'Item Code', 'field' => 'skuid'),
            array('title' => 'Item Name', 'field' => 'item_name'),
            array('title' => 'Kg', 'field' => 'uom_name'),
            array('title' => 'Type Price', 'field' => ''),
            array('title' => 'Qty', 'field' => 'qty'),
            array('title' => 'Total Amount', 'field' => 'amount_price'),
            array('title' => 'DO No.', 'field' => 'delivery_order_no'),
            array('title' => 'Disc.', 'field' => 'tax_value'),
            array('title' => 'Total Amount (After Disc).', 'field' => 'total_amount'),
        ];

        $config = [
            'vue-component' => '<index-report-so></index-report-so>',
        ];

        if ($request->ajax()) {
            $query = DeliveryOrderDetail::dataTableQuery($searchValue);
            $start = $request->start;
            $end = $request->end;
            if ($start && $end) {
                $query->whereHas('sales_order_detail', function ($q) use ($start, $end) {
                    $q->whereHas('SalesOrder', function ($query) use ($start, $end) {
                        $query->whereBetween(DB::raw("DATE_FORMAT(fulfillment_date, '%Y-%m-%d')"), array($start,$end));
                    });
                });
            }
            return ReportSOResource::collection($query->paginate(10));
        }

        return view('layouts.vue-view', compact('config'));

    }
}
