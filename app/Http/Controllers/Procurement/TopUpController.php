<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Model\FinanceAP\InOutPayment;
use App\Model\FinanceAP\RequestFinance;
use App\Model\FinanceAP\RequestFinanceDetail;
use App\Model\FinanceAP\TopUpProc;
use App\Model\MasterData\Vendor;
use App\User;
use App\UserProc;
use App\UserProfile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TopUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchValue = $request->input('search');

        $columns = [
            array('title' => 'Action', 'field' => 'user_name'),
            array('title' => 'Tanggal Pengajuan', 'field' => 'date'),
            array('title' => 'User Procurement', 'field' => 'user_name'),
            array('title' => 'Amount', 'field' => 'amount', 'type' => 'price'),
            array('title' => 'Status', 'field' => 'status_name', 'type' => 'html'),
            array('title' => 'Remarks', 'field' => 'remark'),
        ];

        $config = [
            //Title Required
            'title' => 'TopUp Procurement',
            /*
             * Route Can Be Null
             */
            'route-approve-topup' => 'admin.financeAP.topup.approve',
            'route-reject-topup' => 'admin.financeAP.topup.reject',
            'route-search' => 'admin.financeAP.topup.index',
        ];

        $query = TopUpProc::dataTableQuery($searchValue)->orderBy('status', 'asc');
        $data = $query->paginate(10);

        return view('admin.crud.index', compact('columns', 'data', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function approve($id)
    {
        $topUp = TopUpProc::find($id);

        if ($topUp->status == 1) {
            $topUp->status = 2;
            $topUp->save();

            $userProc = UserProc::find($topUp->user_proc_id);
            $userProc->saldo = intval($userProc->saldo) + $topUp->amount;
            $userProc->save();

            $user = User::find($userProc->user_id);
            $vendor = Vendor::where('users_id', $user->id)->first();

            $data = [
                'no_request' => $this->generateRequestNo(),
                'vendor_id' => $vendor->id,
                'status' => 3,
                'master_warehouse_id' => 1,
                'request_date' => Carbon::now()->toDateString(),
                'request_type' => 2,
                'product_type' => 1,
                'created_at' => Carbon::now(),
                'created_by' => $user->id,
            ];

            $requestFinance = RequestFinance::insertGetId($data);

            RequestFinanceDetail::create([
                'request_finance_id' => $requestFinance,
                'item_name' => 'TopUp Procurement',
                'skuid' => '000',
                'qty' => 1,
                'uom_id' => 2,
                'price' => $topUp->amount,
                'ppn' => 0,
                'pph' => 0,
                'total' => $topUp->amount,
                'supplier_id' => $vendor->id,
                'remarks' => $topUp->remark,
                'created_at' => Carbon::now(),
            ]);

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
                'no_voucher' => $this->generateNoVoucher(),
                'transaction_date' => Carbon::now()->toDateString(),
                'bank_id' => $bank_id,
                'bank_account' => $bank_account,
                'amount' => $topUp->amount,
                'remarks' => null,
                'status' => 3,
                'type_transaction' => 2,
                'option_transaction' => 0,
                'created_at' => Carbon::now(),
            ]);
        }

        return redirect('admin/finance-ap/topup');
    }

    public function reject($id)
    {
        $topUp = TopUpProc::find($id);

        if ($topUp->status == 1) {
            $topUp->status = 3;
            $topUp->save();
        }

        return redirect('admin/finance-ap/topup');
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
}
