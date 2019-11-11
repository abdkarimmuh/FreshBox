<?php

namespace App\Exports;

use App\Model\Warehouse\DeliveryOrderDetail;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ReportFinanceARExport implements FromView
{


    /**
     * @return View
     */
    public function view(): View
    {
        $searchValue = request()->input('search');

        $query = DeliveryOrderDetail::dataTableQuery($searchValue);
        $start = request()->start;
        $end = request()->end;
        if ($start && $end) {
            $query->whereHas('sales_order_detail', function ($q) use ($start, $end) {
                $q->whereHas('SalesOrder', function ($query) use ($start, $end) {
                    $query->whereBetween(DB::raw("DATE_FORMAT(fulfillment_date, '%Y-%m-%d')"), array($start, $end));
                });
            });
        }
        $data = $query->get();
        return view('admin.export.export_report_finance_ar', compact('data'));
    }
}
