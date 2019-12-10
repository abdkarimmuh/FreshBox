<?php

namespace App\Http\Controllers\ApiV1\FinanceAP;

use App\Http\Controllers\Controller;
use App\Model\FinanceAP\RequestFinance;
use App\Model\FinanceAP\RequestFinanceDetail;
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
        $rules = [
            'userId' => 'required',
            'warehouseId' => 'required',
            'requestDate' => 'required',
            'requestType' => 'required',
            'productType' => 'required',
        ];
        $request->validate($rules);
        $data = [
            'user_id' => $request->userId,
            'master_warehouse_id' => $request->warehouseId,
            'request_date' => $request->requestDate,
            'request_type' => $request->requestType,
            'product_type' => $request->productType
        ];
        $requestFinance = RequestFinance::insertGetId($data);

        $orderDetails = $request->orderDetails;
        foreach ($orderDetails as $i => $detail) {
            $requestFinanceDetails[] = [
                'request_finance_id' => $requestFinance->id,
                'type_of_goods' => $detail['typeOfGoods'],
                'qty' => $detail['qty'],
                'unit' => $detail['unit'],
                'price' => $data['price'],
                'ppn' => $data['ppn'],
                'total' => $data['total'],
                'supplier_name' => $data['supplierName'],
                'remarks' => $data['remark'],
            ];
        }
        RequestFinanceDetail::insert($requestFinanceDetails);
    }

    public function generateSalesOrderNo($date)
    {
        $year_month = Carbon::parse($date)->format('/m/Y');
        $latestRequestFinance = RequestFinance::where(DB::raw("DATE_FORMAT(created_at, '/%y/%m')"), $year_month)->latest()->first();
        $latestRequestFinanceNo = isset($latestRequestFinance->no_request) ? $latestRequestFinance->no_request : '1/GF-FB';
        $cutString = str_replace('/GF-FB', '', $latestRequestFinanceNo);
        return ($cutString + 1) . '/GF-FB' . $year_month;
    }


}
