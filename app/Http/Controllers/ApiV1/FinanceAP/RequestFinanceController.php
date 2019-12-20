<?php

namespace App\Http\Controllers\ApiV1\FinanceAP;

use App\Http\Controllers\Controller;
use App\Http\Resources\FinanceAP\RequestFinanceResource;
use App\Model\FinanceAP\RequestFinance;
use App\Model\FinanceAP\RequestFinanceDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RequestFinanceController extends Controller
{
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;
        $query = RequestFinance::dataTableQuery($searchValue);
        if ($request->start && $request->end) {
            $query->whereBetween('no_request', [$request->start, $request->end]);
        }
        if ($searchValue) {
            $query = $query->orderBy('no_request', 'desc')->take(20)->paginate(20);
        } else {
            $query = $query->orderBy('no_request', 'desc')->paginate($perPage);
        }

        return RequestFinanceResource::collection($query);
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

        $noRequest = $this->generateRequestNo($request->date);
        $data = [
            'no_request' => $noRequest,
            'user_id' => $request->userId,
            'master_warehouse_id' => $request->warehouseId,
            'request_date' => $request->requestDate,
            'request_type' => $request->requestType,
            'product_type' => $request->productType,
            'created_at' => now(),
            'created_by' => auth('api')->user()->id
        ];
        $requestFinance = RequestFinance::insertGetId($data);
        $orderDetails = $request->orderDetails;
        foreach ($orderDetails as $i => $detail) {
            $requestFinanceDetails[] = [
                'request_finance_id' => $requestFinance,
                'item_name' => $detail['name'],
                'type_of_goods' => $detail['typeOfGoods'],
                'qty' => $detail['qty'],
                'unit' => $detail['unit'],
                'price' => $detail['price'],
                'ppn' => $detail['ppn'],
                'total' => $detail['total'],
                'supplier_name' => $detail['supplierName'],
                'remarks' => $detail['remark'],
            ];
        }
        RequestFinanceDetail::insert($requestFinanceDetails);
    }

    public function generateRequestNo($date)
    {
        $year_month = Carbon::parse($date)->format('y-m');
        $latestRequestFinance = RequestFinance::where(DB::raw("DATE_FORMAT(request_date, '%y-%m')"), $year_month)->latest()->first();
        $latestRequestFinanceNo = isset($latestRequestFinance->no_request) ? $latestRequestFinance->no_request : '0/GF-FB';
        $cutString = str_replace('/GF-FB', '', $latestRequestFinanceNo);
        return ($cutString + 1) . '/GF-FB';
    }


}
