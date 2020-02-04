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
        $query = $query->groupBy('customer_group_id')
            ->select(DB::raw('count(*) as total_skuid, customer_group_id'))
            ->orderBy('end_periode', 'asc')
            ->get();

        $data = ReportPriceUploadResource::collection($query);

        $data = DB::select("
            select c.`name`, count(distinct b.id) as total_cust, count(distinct a.`skuid`) as total_skuid, max(a.`end_periode`) as end_periode ,
            case when DATEDIFF(max(a.end_periode) , max(a.`start_periode`)) < 7 then 'Weekly'
                when DATEDIFF(max(a.end_periode) , max(a.`start_periode`)) between 8  and 17 then '2 Weekly'
                when DATEDIFF(max(a.end_periode) , max(a.`start_periode`)) between 18 and 32 then 'Monthly'
                when DATEDIFF(max(a.end_periode) , max(a.`start_periode`)) > 32 then '2 Monthly' end as type_price
            ,
            case when max(a.`end_periode`) < now() then 'need upload' else 'updated' end as remarks
            from
                `master_price_groupcust` as a,
                `master_customer` as b,
                `master_customer_group` as c
            where a.`customer_group_id` = b.`customer_group_id`
            and b.`customer_group_id` = c.`id`
            group by  c.`name`
            order by end_periode
        ");

        return view('admin.export.export_report_price_upload', compact('data'));
    }
}
