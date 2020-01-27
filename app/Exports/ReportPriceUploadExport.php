<?php

namespace App\Exports;

use App\Http\Resources\Report\ReportPriceUploadResource;
use App\Model\MasterData\PriceGroupCust;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromView;

class ReportPriceUploadExport implements FromView
{
    /**
     * @return View
     */
    public function view(): View
    {
        $searchValue = request()->input('query');

        $query = PriceGroupCust::dataTableQuery($searchValue);
        $start = request()->start;
        $end = request()->end;
        if ($start && $end) {
            $query->whereBetween(DB::raw("DATE_FORMAT(start_periode, '%Y-%m-%d')"), array($start, $end));
        }
        $query = ReportPriceUploadResource::collection(
            $query->groupBy('customer_group_id')
            ->select(DB::raw('count(*) as tot_skuid, customer_group_id'))
            ->orderBy('end_periode', 'asc')
            ->get()
        );

        $data = $query;

        return view('admin.export.export_report_price_upload', compact('data'));
    }
}
