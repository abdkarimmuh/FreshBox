<?php

namespace App\Http\Controllers\Report;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\Finance\InvoiceOrder;
use App\Model\Marketing\SalesOrderDetail;
use App\Model\MasterData\Customer;
use App\Model\Warehouse\DeliveryOrder;
use Illuminate\Support\Facades\DB;

class reportSOController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
            //Title Required
            'title' => 'Report X',
            /**
             * Route Can Be Null
             */
            //Route For Button Add

            //Route For Button Search
            'route-search' => 'admin.report.reportso.index',
        ];

      /*   $salesOrderDetail = SalesOrderDetail::all();
        $count = 0;

        foreach ($salesOrderDetail as $row) {
            $count = $count + 1;
            $number[] = [
                'number' => ($count)
            ];
        }

        $merge = $salesOrderDetail->merge($number); */

        $query = SalesOrderDetail::dataTableQuery($searchValue);
        $data = $query->paginate(10);

        return view('admin.crud.index', compact('columns', 'data', 'config'));
        // return $data;
    }
}
