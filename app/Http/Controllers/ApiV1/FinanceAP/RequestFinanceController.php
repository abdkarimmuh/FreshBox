<?php

namespace App\Http\Controllers\ApiV1\FinanceAP;

use App\Http\Controllers\Controller;
use App\Http\Resources\FinanceAP\RequestFinanceResource;
use App\Http\Resources\FinanceAP\RequestFinanceWithDetailResource;
use App\Model\FinanceAP\InOutPayment;
use App\Model\FinanceAP\PettyCash;
use App\Model\FinanceAP\RequestFinance;
use App\Model\FinanceAP\RequestFinanceDetail;
use App\Model\MasterData\Vendor;
use App\User;
use App\UserProfile;
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

    public function show($id)
    {
        return new RequestFinanceWithDetailResource(RequestFinance::find($id));
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $rules = [
            'userId' => 'required',
            'warehouse' => 'required',
            'requestDate' => 'required',
            'requestType' => 'required',
            'productType' => 'required',
            'orderDetails' => 'required',
        ];
        $request->validate($rules);

        $noRequest = $this->generateRequestNo($request->date);
        $data = [
            'no_request' => $noRequest,
            'vendor_id' => $request->userId,
            'status' => 1,
            'master_warehouse_id' => $request->warehouse,
            'request_date' => $request->requestDate,
            'request_type' => $request->requestType,
            'product_type' => $request->productType,
            'created_at' => now(),
            'created_by' => auth('api')->user()->id,
        ];
        $requestFinance = RequestFinance::insertGetId($data);
        $orderDetails = $request->orderDetails;
        $total = 0;
        foreach ($orderDetails as $i => $detail) {
            $requestFinanceDetails[] = [
                'request_finance_id' => $requestFinance,
                'item_name' => $detail['name'],
                'type_of_goods' => $detail['typeOfGoods'],
                'qty' => $detail['qty'],
                'uom_id' => $detail['uom_id'],
                'price' => $detail['price'],
                'ppn' => $detail['ppn'],
                'total' => $detail['price'] * $detail['qty'] + ($detail['price'] * $detail['qty'] * $detail['ppn'] /100),
                'supplier_name' => $detail['supplierName'],
                'remarks' => $detail['remark'],
                'created_at' => now(),
            ];

            $total = $total + ($detail['price'] * $detail['qty'] + ($detail['price'] * $detail['qty'] * $detail['ppn'] /100));
        }
        RequestFinanceDetail::insert($requestFinanceDetails);

        if ($request->requestType == 1) {
            PettyCash::create([
                'finance_request_id' => $requestFinance,
                'amount' => $total,
                'no_trx' => $noRequest,
                'created_at' => now(),
            ]);
        }
        else {
            $vendor = Vendor::find($request->userId);
            $user = User::where('name', 'like', $vendor->name)->first();
            if ($user == null) {
                $bank_id = $this->vendor->bank_id;
                $norek = $this->vendor->bank_account;
            } else {
                $user_profile = UserProfile::where('user_id', $user->id)->first();
                $bank_id = isset($user_profile->bank_id) ? $user_profile->bank_id : '';
                $norek = isset($user_profile->no_rek) ? $user_profile->no_rek : '';

            }
            InOutPayment::create([
                'finance_request_id' => $requestFinance,
                'source' => null,
                'transaction_date' => now()->toDateString(),
                'bank_id' => $bank_id,
                'no_rek' => $norek,
                'amount' => $total,
                'remarks' => null,
                'status' => 1,
                'type_transaction' => 1,
                'created_at' => now(),
            ]);
        }
    }

    public function generateRequestNo($date)
    {
        $year_month = Carbon::parse($date)->format('y-m');
        $latestRequestFinance = RequestFinance::where(DB::raw("DATE_FORMAT(request_date, '%y-%m')"), $year_month)->latest()->first();
        $latestRequestFinanceNo = isset($latestRequestFinance->no_request) ? $latestRequestFinance->no_request : '0/GF-FB';
        $cutString = str_replace('/GF-FB', '', $latestRequestFinanceNo);

        return ($cutString + 1).'/GF-FB';
    }

    public function setDate(Request $request)
    {
        $rules = [
            'confirmDate' => 'required',
            'orderDetails' => 'required',
        ];
        $request->validate($rules);
    }

    public function confirmed($id)
    {
        $requestFinance = RequestFinance::find($id);
        $requestFinance->status = 2;
        $requestFinance->save();

        return response()->json([
            'success' => true,
            'requestFinance' => $requestFinance,
        ]);
    }

    public function requestFinanceDetail($id)
    {
        $requestFinanceDetail = RequestFinanceDetail::where('request_finance_id', $id)->get();

        return response()->json([
            'success' => true,
            'data' => $requestFinanceDetail,
        ]);
    }

    public function update(Request $request)
    {
        $requestFinance = RequestFinance::find($request->id);
        $requestFinance->product_type = $request->productType;
        $requestFinance->master_warehouse_id = $request->warehouse;
        $requestFinance->updated_at = now();
        $requestFinance->save();

        RequestFinanceDetail::where('request_finance_id', $request->id)->delete();

        foreach ($request->detail as $detail) {
            $items[] = [
                'request_finance_id' => $request->id,
                'item_name' => $detail['item_name'],
                'type_of_goods' => $detail['type_of_goods'],
                'qty' => $detail['qty'],
                'uom_id' => $detail['uom_id'],
                'price' => $detail['price'],
                'ppn' => $detail['ppn'],
                'total' => $detail['price'] * $detail['qty'] + ($detail['price'] * $detail['qty'] * $detail['ppn'] /100),
                'supplier_name' => $detail['supplier_name'],
                'remarks' => $detail['remarks'],
                'created_at' => $requestFinance->created_at,
                'updated_at' => now(),
            ];
        }

        RequestFinanceDetail::insert($items);

        return response()->json([
            'success' => true,
        ]);
    }
}
