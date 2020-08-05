<?php

namespace App\Http\Controllers\Report;

use Carbon\Carbon;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Exports\ReportDOExport;
use App\Exports\ReportSOExport;
use App\Model\MasterData\Customer;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ReportFinanceARExport;
use Illuminate\Contracts\View\Factory;
use App\Exports\ReportPriceUploadExport;
use App\Model\MasterData\PriceGroupCust;
use App\Model\Warehouse\DeliveryOrderDetail;
use App\Http\Resources\Report\ReportSOResource;
use App\Http\Resources\Report\ReportFinanceARResource;
use App\Http\Resources\Report\ReportPriceUploadResource;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Factory|AnonymousResourceCollection|View
     */
    public function reportSO(Request $request)
    {
        $searchValue = $request->input('query');

        $config = [
            'vue-component' => '<index-report-so/>',
        ];

        if ($request->ajax()) {
            $query = DeliveryOrderDetail::dataTableQuery($searchValue);
            $start = $request->start;
            $end = $request->end;
            if ($start && $end) {
                $query->whereHas('sales_order_detail', function ($q) use ($start, $end) {
                    $q->whereHas('SalesOrder', function ($query) use ($start, $end) {
                        $query->whereBetween(DB::raw("DATE_FORMAT(fulfillment_date, '%Y-%m-%d')"), array($start, $end));
                    });
                });
            }

            return ReportSOResource::collection($query->paginate(10));
        }

        return view('layouts.vue-view', compact('config'));
    }

    public function reportDO(Request $request)
    {
        $soDate = date('Y-m-d');
        $dataSO = DB::select(DB::raw("
            SELECT so.id as 'soid', so.sales_order_no AS 'SONO', 
            do_order.delivery_order_no AS 'DONO' , cst.name AS 'CustName',
            cst.customer_code AS 'CUSTID',  IFNULL(NULL, so.no_po) AS 'NOPO'
        FROM
            trx_sales_order so,
            trx_delivery_order do_order,
            master_customer cst
        WHERE 
            so.id = do_order.sales_order_id and
            cst.id = so.customer_id and so.created_at LIKE '$soDate%' ORDER BY so.id desc;
                        "));

        $data = DB::select(DB::raw("
        SELECT so.sales_order_no AS 'SONO', so.created_at AS 'SODate',
        do_order.delivery_order_no AS 'DONO' , 
        do_order.do_date AS 'DODate', cst.name AS 'CustName',
        cst.customer_code AS 'CUSTID',
            i.skuid AS 'SKUID', i.name_item AS 'ItemName', do_det.qty_do AS 'QTYDO', u.name AS 'Unit' , IFNULL(NULL, so.no_po) AS 'NOPO'
        FROM
                trx_sales_order so,
                trx_delivery_order do_order,
                master_customer cst,
                trx_delivery_order_detail do_det,
                master_uom u,
                master_item i
            WHERE 
                so.id = do_order.sales_order_id and
                cst.id = so.customer_id AND do_order.id = do_det.delivery_order_id
                AND i.skuid = do_det.skuid AND u.id = i.uom_id and so.created_at LIKE  '$soDate%'  ORDER BY so.id desc;
                        "));
                        // dd($soDate);
        return view('pure.reportdo', compact('data','dataSO'));
    }

    public function reportb2b(Request $request)
    {
        $start = $request->start;
        $end = $request->end;

        // $start = '2020-07-29';
        // $end = '2020-07-29';

        $data = null;
        if ($start && $end) {
            $data = DB::select(DB::raw("
        SELECT so.sales_order_no AS 'SONO', so.created_at AS 'SODate',
        do_order.delivery_order_no AS 'DONO' , 
        do_order.do_date AS 'DODate', cst.name AS 'CustName',
        cst.customer_code AS 'CUSTID',
            i.skuid AS 'SKUID', i.name_item AS 'ItemName',so_det.qty AS 'QTYSO',  do_det.qty_do AS 'QTYDO',  so_det.amount_price AS 'Amount', so_det.total_amount as 'Total Amount', u.name AS 'Unit' , IFNULL(NULL, so.no_po) AS 'NOPO'
        FROM
                trx_sales_order so,
               trx_sales_order_detail so_det,
                trx_delivery_order do_order,
                master_customer cst,
                trx_delivery_order_detail do_det,
                master_uom u,
                master_item i
            WHERE 
                
					  so.id = so_det.sales_order_id
					 AND so.id = do_order.sales_order_id
					 AND so.customer_id = cst.id
					 AND do_order.id = do_det.delivery_order_id
					 AND i.skuid = so_det.skuid
                AND i.skuid = do_det.skuid
					 AND u.id = i.uom_id and (so.fulfillment_date BETWEEN '$start' AND '$end')
                "));

        }
        else{
            $data = DB::select(DB::raw("
            SELECT so.sales_order_no AS 'SONO', so.created_at AS 'SODate',
            do_order.delivery_order_no AS 'DONO' , 
            do_order.do_date AS 'DODate', cst.name AS 'CustName',
            cst.customer_code AS 'CUSTID',
                i.skuid AS 'SKUID', i.name_item AS 'ItemName',so_det.qty AS 'QTYSO',  do_det.qty_do AS 'QTYDO',  so_det.amount_price AS 'Amount', so_det.total_amount as 'Total Amount', u.name AS 'Unit' , IFNULL(NULL, so.no_po) AS 'NOPO'
            FROM
                    trx_sales_order so,
                trx_sales_order_detail so_det,
                    trx_delivery_order do_order,
                    master_customer cst,
                    trx_delivery_order_detail do_det,
                    master_uom u,
                    master_item i
                WHERE 
                    
                        so.id = so_det.sales_order_id
                        AND so.id = do_order.sales_order_id
                        AND so.customer_id = cst.id
                        AND do_order.id = do_det.delivery_order_id
                        AND i.skuid = so_det.skuid
                    AND i.skuid = do_det.skuid
                        AND u.id = i.uom_id;
                "));
        }
       

                        return $data;
        // return view('pure.reportdo', compact('data','dataSO'));
    }
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Factory|AnonymousResourceCollection|View
     */
    public function reportFinanceAR(Request $request)
    {
        $searchValue = $request->input('query');
        $config = [
            'vue-component' => '<index-report-finance-ar/>',
        ];

        if ($request->ajax()) {
            $query = DeliveryOrderDetail::dataTableQuery($searchValue);
            $start = $request->start;
            $end = $request->end;
            if ($start && $end) {
                $query->whereHas('sales_order_detail', function ($q) use ($start, $end) {
                    $q->whereHas('SalesOrder', function ($query) use ($start, $end) {
                        $query->whereBetween(DB::raw("DATE_FORMAT(fulfillment_date, '%Y-%m-%d')"), array($start, $end));
                    });
                });
            }

            return ReportFinanceARResource::collection($query->paginate(10));
        }

        return view('layouts.vue-view', compact('config'));
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Factory|AnonymousResourceCollection|View
     */
    public function reportPriceUpload(Request $request)
    {
        $searchValue = $request->input('query');
        $config = [
            'vue-component' => '<index-report-price-upload/>',
        ];

        if ($request->ajax()) {
            $query = PriceGroupCust::dataTableQuery($searchValue);
            $start = $request->start;
            $end = $request->end;
            if ($start && $end) {
                $query->whereBetween(DB::raw("DATE_FORMAT(end_periode, '%Y-%m-%d')"), array($start, $end));
            }

            $customerGroupId = Customer::pluck('customer_group_id')->all();

            $collections = ReportPriceUploadResource::collection(
                $query
                ->whereIn('customer_group_id', $customerGroupId)
                ->select('customer_group_id', 'start_periode', 'end_periode', DB::raw('count(*) as total_skuid'))
                ->groupBy('customer_group_id')
                ->where('customer_group_id', '!=', null)
                ->orderBy('end_periode', 'asc')
                ->paginate($request->perPage)
            );

            return $collections;
        }

        return view('layouts.vue-view', compact('config'));
    }

    /**
     * Export Data Report SO To Excel.
     *
     * @return BinaryFileResponse
     */
    public function exportSO()
    {
        $now = Carbon::now();

        return Excel::download(new ReportSOExport(), 'Report Sales Order - '.$now.'.xlsx');
    }

    public function exportDO()
    {
        $now = Carbon::now();
        return Excel::download(new ReportDOExport(), 'Report Sales Order - '.$now.'.xlsx');
    }

    /**
     * Export Data Report Finance AR To Excel.
     *
     * @return BinaryFileResponse
     */
    public function exportFinanceAR()
    {
        $now = Carbon::now();

        return Excel::download(new ReportFinanceARExport(), 'Report Finance AR - '.$now.'.xlsx');
    }

    /**
     * Export Data Report Finance AR To Excel.
     *
     * @return BinaryFileResponse
     */
    public function exportPriceUpload()
    {
        $now = Carbon::now();

        return Excel::download(new ReportPriceUploadExport(), 'Report Price Upload - '.$now.'.xlsx');
    }
}
