<?php

namespace App\Http\Controllers\ApiV1\FinanceAP;

use App\Http\Controllers\Controller;
use App\Http\Resources\FinanceAP\ReplenishResource;
use App\Model\FinanceAP\InOutPayment;
use App\Model\FinanceAP\Replenish;
use App\Model\FinanceAP\RequestFinance;
use App\Model\FinanceAP\RequestFinanceDetail;
use App\Model\MasterData\Vendor;
use App\Model\Procurement\ListProcurement;
use App\Model\Procurement\ListProcurementDetail;
use App\Model\WarehouseIn\Confirm;
use App\User;
use App\UserProc;
use App\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ReplenishAPIController extends Controller
{
    /**
     * List Data Replenish.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;
        $query = Replenish::dataTableQuery($searchValue)->orderBy('status', 'desc');
        if ($request->start && $request->end) {
            $query->whereHas('procurement', function ($q) use ($request) {
                $q->whereBetween('procurement_no', [$request->start, $request->end]);
            });
        }
        if ($searchValue) {
            $query = $query->take(20)->paginate(20);
        } else {
            $query = $query->paginate($perPage);
        }

        return ReplenishResource::collection($query);
    }

    /**
     *Insert the replenish data.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|not_in:0',
            'totalAmount' => 'required',
            'listProcId' => 'required',
        ]);

        $data = [
            'userProcId' => intval($request->userProcId),
            'status' => intval($request->status),
            'total_amount' => $request->totalAmount,
            'list_proc_id' => $request->listProcId,
            'remark' => $request->remark,
            'created_by' => auth('api')->user()->id,
        ];

        Replenish::create($data);

        if ($data['status'] == 1) {
            $status = 4;

            $userProc = UserProc::find($data['userProcId']);
            $saldo = $userProc->saldo + $data['total_amount'];
            $userProc->saldo = $saldo;
            $userProc->save();

            $confirm = Confirm::where('list_procurement_id', $request->listProcId)->first();
            $confirm->status = 3;
            $confirm->save();

            $user = User::find($userProc->user_id);
            $vendor = Vendor::where('users_id', $user->id)->first();

            $data = [
                'no_request' => $this->generateRequestNo(),
                'vendor_id' => $vendor->id,
                'status' => 3,
                'master_warehouse_id' => 1,
                'request_date' => Carbon::now()->toDateString(),
                'request_type' => 2,
                'product_type' => 2,
                'created_at' => Carbon::now(),
                'created_by' => $userProc->user_id,
            ];
            $requestFinance = RequestFinance::insertGetId($data);

            $listProcurement = ListProcurement::find($request->listProcId);
            $listProcurementDetail = ListProcurementDetail::where('trx_list_procurement_id', $listProcurement->id)->get();

            $total = 0;

            foreach ($listProcurementDetail as $detail) {
                $requestFinanceDetails[] = [
                    'request_finance_id' => $requestFinance,
                    'item_name' => $detail->item_name,
                    'skuid' => $detail->skuid,
                    'qty' => $detail->qty,
                    'uom_id' => $detail->uom_id,
                    'price' => $detail->amount,
                    'ppn' => 0,
                    'total' => $detail->amount,
                    'supplier_id' => $listProcurement->vendor->id,
                    'remarks' => '',
                    'created_at' => now(),
                ];

                $total = $total + $detail->amount;
            }
            RequestFinanceDetail::insert($requestFinanceDetails);

            $user_profile = UserProfile::where('user_id', $user->id)->first();
            $bank_id = isset($user_profile->bank_id) ? $user_profile->bank_id : '';
            $bank_account = isset($user_profile->bank_account) ? $user_profile->bank_account : '';

            InOutPayment::create([
                'finance_request_id' => $requestFinance,
                'source' => null,
                'transaction_date' => Carbon::now()->toDateString(),
                'bank_id' => $bank_id,
                'bank_account' => $bank_account,
                'amount' => $total,
                'remarks' => null,
                'status' => 3,
                'type_transaction' => 2,
                'option_transaction' => 3,
                'created_at' => Carbon::now(),
            ]);
        } elseif ($data['status'] == 2) {
            $status = 5;

            $confirm = Confirm::where('list_procurement_id', $request->listProcId)->first();
            $confirm_id = $confirm->id;

            DB::select('call insert_notification_procurement(?, ?, ?)', array(intval($request->userProcId), $confirm_id, 2));
        }

        ListProcurement::findOrFail($request->listProcId)->update(['status' => $status]);

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     *Insert the replenish data.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function returnReplenish(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'file' => 'required',
        ]);

        $listProcurement = ListProcurement::find($request->id);
        $listProcurement->status = 8;

        $fileName = $listProcurement->file;
        $procNo = $listProcurement->procurement_no;

        if ($request->file) {
            $file = $request->file;
            @list($type, $file_data) = explode(';', $file);
            @list(, $file_data) = explode(',', $file_data);
            $file_name = $procNo.'.'.explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            Storage::disk('local')->delete('public/files/procurement/'.$fileName);
            Storage::disk('local')->put('public/files/procurement/'.$file_name, base64_decode($file_data), 'public');
        } else {
            $file_name = '';
        }

        $listProcurement->save();

        $replenish = Replenish::where('list_proc_id', $listProcurement->id)->first();
        $replenish->status = 3;
        $replenish->save();

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Change Status To Replenish.
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function replenish($id)
    {
        $replenish = Replenish::findOrFail($id);
        $replenish->status = 1;

        $listProcurement = ListProcurement::findOrFail($replenish->list_proc_id);
        $listProcurement->status = 4;

        $userProc = UserProc::find($listProcurement->user_proc_id);
        $saldo = $userProc->saldo + $listProcurement->total_amount;
        $userProc->saldo = $saldo;

        $confirm = Confirm::where('list_procurement_id', $listProcurement->id)->first();
        $confirm->status = 3;

        $listProcurement->save();
        $replenish->save();
        $userProc->save();
        $confirm->save();

        $user = User::find($userProc->user_id);
        $vendor = Vendor::where('users_id', $user->id)->first();

        $data = [
            'no_request' => $this->generateRequestNo(),
            'vendor_id' => $vendor->id,
            'status' => 3,
            'master_warehouse_id' => 1,
            'request_date' => Carbon::now()->toDateString(),
            'request_type' => 2,
            'product_type' => 2,
            'created_at' => Carbon::now(),
            'created_by' => $listProcurement->created_by,
        ];
        $requestFinance = RequestFinance::insertGetId($data);

        $listProcurementDetail = ListProcurementDetail::where('trx_list_procurement_id', $listProcurement->id)->get();
        $total = 0;
        foreach ($listProcurementDetail as $i => $detail) {
            $listProcurementDetails[] = [
                'request_finance_id' => $requestFinance,
                'item_name' => $detail->Item->name,
                'skuid' => $detail->skuid,
                'qty' => $detail->qty,
                'uom_id' => $detail->uom_id,
                'price' => $detail->amount / $detail->qty,
                'ppn' => 0,
                'total' => $detail->amount,
                'supplier_id' => $listProcurement->vendor->id,
                'remarks' => '',
                'created_at' => now(),
            ];

            $total = $total + $detail->amount;
        }

        RequestFinanceDetail::insert($listProcurementDetails);

        if ($vendor->type_vendor == 1) {
            //employee
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
            'transaction_date' => Carbon::now()->toDateString(),
            'bank_id' => $bank_id,
            'bank_account' => $bank_account,
            'amount' => $total,
            'remarks' => null,
            'status' => 3,
            'type_transaction' => 2,
            'created_at' => Carbon::now(),
        ]);

        return response()->json([
            'success' => true,
            'user' => $user,
            'requestFinance' => $requestFinance,
            'listProcurementDetail' => $listProcurementDetail,
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
}
