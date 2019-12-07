<?php

namespace App\Http\Controllers\ApiV1\FinanceAP;

use App\Http\Controllers\Controller;
use App\Model\FinanceAP\RequestFinance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class RequestFinanceController extends Controller
{
    public function index()
    {

    }

    public function create()
    {

    }

    public function store(Request $request)
    {
//        $table->unsignedBigInteger('user_id')->index();
//        $table->unsignedBigInteger('master_warehouse_id')->index();
//        $table->string('no_request')->index();
//        $table->date('request_date')->index();
//        $table->string('no_request_confirm')->nullable();
//        $table->date('request_confirm_date')->nullable();
//        $table->tinyInteger('request_type')->comment('1 = cash , 2 = advance');
//        $table->tinyInteger('product_type')->comment('1 = non core , 2 = core');
//        $table->binary('file')->nullable();
        $data = [
            'user_id' => $request->userId,
            'master_warehouse_id' => $request
        ];
        RequestFinance::insert([

        ]);
    }

    public function generateSalesOrderNo()
    {
        $year_month = Carbon::now()->format('ym');
//        $latest_sales_order = RequestAdvance::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        $latest_sales_order = '280/GF-FB/7/2019';
//        $get_last_so_no = isset($latest_sales_order->sales_order_no) ? $latest_sales_order->sales_order_no : 'SO' . $year_month . '00000';
        $cut_string_so = str_replace('/GF-FB/7/2019', '', $latest_sales_order);

        return ($cut_string_so + 1) . '/GF-FB/7/2019';
    }


}
