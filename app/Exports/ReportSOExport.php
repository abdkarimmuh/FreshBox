<?php

namespace App\Exports;

use App\DeliveryOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Model\Warehouse\DeliveryOrderDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Resources\Report\ReportSOResource;

class ReportSOExport implements FromView
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function View(): View
    {
        $searchValue = request()->input('query');

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
        return view('admin.export.export_report_so', compact('data'));
//        return ReportSOResource::collection($query->get());
    }
}
