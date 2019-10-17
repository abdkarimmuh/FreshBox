<?php

namespace App\Exports;

use App\DeliveryOrder;
use App\Http\Resources\Report\ReportSOResource;
use App\Model\Warehouse\DeliveryOrderDetail;
use Maatwebsite\Excel\Concerns\FromCollection;

class ReportSOExport implements FromCollection
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function collection()
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
        return ReportSOResource::collection($query->get());
    }
}
