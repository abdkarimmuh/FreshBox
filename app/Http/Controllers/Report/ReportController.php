<?php

namespace App\Http\Controllers\Report;

use App\Exports\ReportFinanceARExport;
use App\Exports\ReportSOExport;
use App\Http\Controllers\Controller;
use App\Http\Resources\Report\ReportFinanceARResource;
use App\Http\Resources\Report\ReportSOResource;
use App\Model\Warehouse\DeliveryOrderDetail;
use Carbon\Carbon;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
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

    /**
     * Display a listing of the resource.
     * @param Request $request
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
     * Export Data Report SO To Excel
     * @return BinaryFileResponse
     */
    public function exportSO()
    {
        $now = Carbon::now();
        return Excel::download(new ReportSOExport, 'Report Sales Order - ' . $now . '.xlsx');
    }

    /**
     * Export Data Report Finance AR To Excel
     * @return BinaryFileResponse
     */
    public function exportFinanceAR()
    {
        $now = Carbon::now();
        return Excel::download(new ReportFinanceARExport, 'Report Finance AR - ' . $now . '.xlsx');
    }
}
