<?php

namespace App\Http\Controllers\ApiV1\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportPriceAPIController extends Controller
{
    public function index(Request $request)
    {
        // $respon = DB::select('call upload_price_report');
        $respon = DB::select(DB::raw("
        select c.`name`, count(distinct b.id) as TotCustomer, count(distinct a.`skuid`) as TotSKU, max(a.`end_periode`) as MaxEndPeriode ,
case when DATEDIFF(max(a.end_periode) , max(a.`start_periode`)) < 7 then 'weekly'
	 when DATEDIFF(max(a.end_periode) , max(a.`start_periode`)) between 8  and 17 then '2weekly'
	 when DATEDIFF(max(a.end_periode) , max(a.`start_periode`)) between 18 and 32 then 'Monthly'
	 when DATEDIFF(max(a.end_periode) , max(a.`start_periode`)) > 32 then '2Monthly' end as TypePrice
   ,
case when max(a.`end_periode`) < now() then 'need upload' else 'updated' end as remarks
from
	`master_price_groupcust` as a,
	`master_customer` as b,
	`master_customer_group` as c
where a.`customer_group_id` = b.`customer_group_id`
and b.`customer_group_id` = c.`id`
group by  c.`name`
order by MaxEndPeriode
        "));

        // $searchValue = $request->input('query');
        // $perPage = $request->perPage;
        // $query = $respon->dataTableQuery($searchValue);
        // if ($searchValue) {
        //     $query = $query->take(20)->paginate(20);
        // } else {
        //     $query = $query->paginate($perPage);
        // }

        return response()->json([
            'data' => $respon
        ]);
    }
}
