<?php

namespace App\Http\Controllers\ApiV1\FinanceAP;

use App\Http\Controllers\Controller;
use App\Http\Resources\FinanceAP\NoRequestFinanceResource;
use App\Http\Resources\FinanceAP\RequestFinanceResource;
use App\Http\Resources\FinanceAP\RequestFinanceWithDetailResource;
use App\Model\FinanceAP\InOutPayment;
use App\Model\FinanceAP\PettyCash;
use App\Model\FinanceAP\RequestFinance;
use App\Model\FinanceAP\RequestFinanceDetail;
use App\Model\MasterData\BankAccout;
use App\Model\MasterData\Vendor;
use App\User;
use App\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RequestFinanceController extends Controller
{
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;
        $query = RequestFinance::dataTableQuery($searchValue);
        if ($searchValue) {
            $query = $query->orderBy('id', 'desc')->take(20)->paginate(20);
        } else {
            $query = $query->orderBy('id', 'desc')->paginate($perPage);
        }

        return RequestFinanceResource::collection($query);
    }

    public function get(Request $request)
    {
        $query = RequestFinance::all();

        return RequestFinanceResource::collection($query);
    }

    public function getSettlement(Request $request)
    {
        $query = RequestFinance::where('status', 4)->get();

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

        $noRequest = $this->generateRequestNo();
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
        foreach ($orderDetails as $detail) {
            $requestFinanceDetails[] = [
                'request_finance_id' => $requestFinance,
                'item_name' => $detail['name'],
                'skuid' => $detail['skuid'],
                'qty' => $detail['qty'],
                'uom_id' => $detail['uom_id'],
                'price' => $detail['price'],
                'ppn' => $detail['ppn'],
                'total' => $detail['total'],
                'supplier_id' => $detail['supplier_id'],
                'remarks' => $detail['remarks'],
                'created_at' => now(),
            ];

            $total = $total + ($detail['total']);
        }
        RequestFinanceDetail::insert($requestFinanceDetails);

        if ($request->requestType == 1) {
            PettyCash::create([
                'finance_request_id' => $requestFinance,
                'amount' => $total,
                'no_trx' => $noRequest,
                'created_at' => now(),
            ]);
        } else {
            $vendor = Vendor::find($request->userId);
            if ($vendor->type_vendor == 1) {
                //employee
                $user = User::find($vendor->users_id);
                $user_profile = UserProfile::where('user_id', $user->id)->first();
                $bank_id = isset($user_profile->bank_id) ? $user_profile->bank_id : '';
                $bank_account = isset($user_profile->bank_account) ? $user_profile->bank_account : '';
            } else {
                //vendor
                $bank_id = $vendor->bank_id;
                $bank_account = $vendor->bank_account;
            }
            InOutPayment::create([
                'finance_request_id' => $requestFinance,
                'source' => null,
                'no_voucher' => $this->generateNoVoucher(),
                'transaction_date' => now()->toDateString(),
                'bank_id' => $bank_id,
                'bank_account' => $bank_account,
                'amount' => $total,
                'remarks' => null,
                'status' => 1,
                'type_transaction' => 2,
                'created_at' => now(),
            ]);
        }
    }

    public function upload(Request $request, $id)
    {
        $requestFinance = RequestFinance::find($id);

        //Untuk Mengupload File Ke Storage
        if ($request->file) {
            $file = $request->file;
            @list($type, $file_data) = explode(';', $file);
            @list(, $file_data) = explode(',', $file_data);
            $file_name = $requestFinance->no_request.'.'.explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            Storage::disk('local')->put('public/files/request-advance/'.$file_name, base64_decode($file_data), 'public');
        } else {
            $file_name = '';
        }

        $requestFinance->file = $file_name;
        $requestFinance->status = 2;
        $requestFinance->save();

        $inOutPayment = InOutPayment::where('finance_request_id', $id)->first();
        $inOutPayment->status = 2;
        $inOutPayment->save();

        return response()->json([
            'success' => true,
        ]);
    }

    public function generateRequestNo()
    {
        $year_month = Carbon::now()->format('ym');
        $latest_request = RequestFinance::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        $get_last_request_no = isset($latest_request->no_request) ? $latest_request->no_request : 'ADV'.$year_month.'00000';
        $cut_string_request = str_replace('ADV', '', $get_last_request_no);

        return 'ADV'.($cut_string_request + 1);
    }

    public function generateNoVoucher()
    {
        $year_month = Carbon::now()->format('ym');
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');
        $latest_voucher = InOutPayment::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();

        $get_last_voucher_no = isset($latest_voucher->no_voucher) ? $latest_voucher->no_voucher : '0000/BTS/PV/'.$month.'/'.$year;
        $cut_string_voucher = substr($get_last_voucher_no, 0, 4);
        $cut_string = $cut_string_voucher + 1;

        if (strlen($cut_string) == 1) {
            $string_voucher = '000'.$cut_string;
        } elseif (strlen($cut_string) == 2) {
            $string_voucher = '00'.$cut_string;
        } elseif (strlen($cut_string) == 3) {
            $string_voucher = '0'.$cut_string;
        } else {
            $string_voucher = $cut_string;
        }

        return $string_voucher.'/BTS/PV/'.$month.'/'.$year;
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

    public function update(Request $request)
    {
        $requestFinance = RequestFinance::find($request->id);
        $requestFinance->product_type = $request->productType;
        $requestFinance->master_warehouse_id = $request->warehouse;
        $requestFinance->updated_at = now();

        RequestFinanceDetail::where('request_finance_id', $request->id)->delete();

        $total = 0;

        foreach ($request->detail as $detail) {
            $items[] = [
                'request_finance_id' => $request->id,
                'item_name' => $detail['item_name'],
                'skuid' => $detail['skuid'],
                'qty' => $detail['qty'],
                'uom_id' => $detail['uom_id'],
                'price' => $detail['price'],
                'ppn' => $detail['ppn'],
                'total' => $detail['total'],
                'supplier_id' => $detail['supplier_id'],
                'remarks' => $detail['remarks'],
                'created_at' => $requestFinance->created_at,
                'updated_at' => now(),
            ];
            $total = $total + $detail['total'];
        }

        RequestFinanceDetail::insert($items);

        $inOutPayment = InOutPayment::where('finance_request_id', $requestFinance->id)->first();
        $inOutPayment->amount = $total;

        if ($request->file) {
            $file = $request->file;
            @list($type, $file_data) = explode(';', $file);
            @list(, $file_data) = explode(',', $file_data);
            $file_name = $requestFinance->no_request.'.'.explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            Storage::disk('local')->put('public/files/request-advance/'.$file_name, base64_decode($file_data), 'public');

            $requestFinance->file = $file_name;
            $requestFinance->status = 2;

            $inOutPayment->status = 2;
        }
        $inOutPayment->save();

        $requestFinance->save();

        return response()->json([
            'success' => true,
        ]);
    }

    public function getNoRequestAdvance(Request $request, $id)
    {
        if ($id == 1) {
            $requestFinance = RequestFinance::where('status', 6)->get();
        } else {
            $requestFinance = RequestFinance::where('status', 7)->get();
        }

        return NoRequestFinanceResource::collection($requestFinance);
    }

    public function getBank($id)
    {
        $requestFinance = new RequestFinanceResource(RequestFinance::find($id));

        return response()->json([
            'data' => $requestFinance,
        ]);
    }

    public function getBankAccount($id)
    {
        $bank_account = BankAccout::find($id);

        return response()->json([
            'data' => $bank_account->bank_account,
        ]);
    }

    public function getAmount($id)
    {
        $requestFinance = RequestFinance::find($id);

        return response()->json([
            'total' => $requestFinance->total,
            'price' => $requestFinance->price,
            'sisa' => abs($requestFinance->price - $requestFinance->total),
        ]);
    }
}
