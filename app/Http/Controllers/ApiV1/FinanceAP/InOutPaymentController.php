<?php

namespace App\Http\Controllers\ApiV1\FinanceAP;

use App\Http\Controllers\Controller;
use App\Http\Resources\FinanceAP\InOutPaymentResource;
use App\Model\FinanceAP\InOutPayment;
use App\Model\FinanceAP\RequestFinance;
use App\Model\FinanceAP\RequestFinanceDetail;
use App\Model\FinanceAP\Settlement;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InOutPaymentController extends Controller
{
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;
        $query = InOutPayment::where('status', '>', 1)->dataTableQuery($searchValue);
        if ($searchValue) {
            $query = $query->orderBy('created_at', 'desc')->take(20)->paginate(20);
        } else {
            $query = $query->orderBy('created_at', 'desc')->paginate($perPage);
        }

        return InOutPaymentResource::collection($query);
    }

    public function show(Request $request, $id)
    {
        if (is_array($id)) {
            $inv = InOutPayment::whereIn('id', $id)->get();
            $invoice_order = InOutPaymentResource::collection($inv);
        } elseif ($request->printAll == true) {
            $inv = InOutPayment::where('is_printed', 0)->get();
            $invoice_order = InOutPaymentResource::collection($inv);
        } else {
            $inv = InOutPayment::findOrFail($id);
            $invoice_order = new InOutPaymentResource($inv);
        }

        return response()->json($invoice_order, 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'type_transaction' => 'required',
            'option_transaction' => 'required',
            'source' => 'required',
            'bank_id' => 'required',
            'bank_account' => 'required',
            'transaction_date' => 'required',
            'amount' => 'required',
        ];

        if ($request->option_transaction != 3) {
            $validation_option = ['file' => 'required'];
        } else {
            $validation_option = [];
        }

        $request->validate(array_merge($rules, $validation_option));

        //Untuk Mengupload File Ke Storage
        if ($request->file) {
            $file = $request->file;
            @list($type, $file_data) = explode(';', $file);
            @list(, $file_data) = explode(',', $file_data);
            $file_name = $this->generateNoFile().'.'.explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            Storage::disk('local')->put('public/files/in-out/'.$file_name, base64_decode($file_data), 'public');
        } else {
            $file_name = null;
        }

        if ($request->option_transaction == 1) {
            $requestFinance = RequestFinance::find($request->source);
            $settlementAdvance = Settlement::where('request_finance_id', $requestFinance->id)->first();

            $source = $requestFinance->no_request;

            $requestFinance->status = 5;
            $requestFinance->updated_at = Carbon::now();
            $requestFinance->save();

            $settlementAdvance->status = 1;
            $settlementAdvance->updated_at = Carbon::now();
            $settlementAdvance->save();
        } else {
            $source = $request->source;
        }

        $in_out_payment = [
            'type_transaction' => $request->type_transaction,
            'option_transaction' => $request->option_transaction,
            'source' => $source,
            'no_voucher' => $this->generateNoVoucher($request->type_transaction),
            'transaction_date' => $request->transaction_date,
            'amount' => $request->amount,
            'bank_id' => $request->bank_id,
            'bank_account' => $request->bank_account,
            'file' => $file_name,
            'remarks' => $request->remark,
            'status' => 4,
            'created_at' => Carbon::now(),
        ];

        InOutPayment::create($in_out_payment);

        return response()->json([
            'status' => 'success', 'request' => $request->all(),
        ], 200);
    }

    public function changeStatus($id)
    {
        $inout = InOutPayment::where('finance_request_id', $id)->first();
        $inout->status = $inout->status + 1;
        $inout->save();

        $req_finance = RequestFinance::find($id);
        $req_finance->status = $req_finance->status + 1;
        $req_finance->save();
    }

    public function changeStatusReject($id)
    {
        $inout = InOutPayment::where('finance_request_id', $id)->first();
        $inout->status = 7;
        $inout->save();

        $req_finance = RequestFinance::find($id);
        $req_finance->status = 8;
        $req_finance->save();
    }

    public function confirm(Request $request, $id)
    {
        $rules = [
            'no_payment' => 'required',
            'confirm_date' => 'required',
        ];

        $request->validate($rules);

        $inout = InOutPayment::find($id);
        $req_finance = RequestFinance::find($inout->finance_request_id);

        if ($inout->status == 3 && $req_finance->status == 3) {
            $inout->status = $inout->status + 1;
            $req_finance->status = $req_finance->status + 1;
        } elseif ($inout->status == 6 && $req_finance->status == 7) {
            $inout->status = 4;
            $req_finance->status = 5;

            $settlement = Settlement::where('request_finance_id', $inout->finance_request_id)->first();
            $settlement->status = 1;
            $settlement->save();
        }

        $inout->save();

        $req_finance->no_payment = $request->no_payment;
        $req_finance->confirm_date = $request->confirm_date;
        $req_finance->save();

        return response()->json([
            'status' => 'success', 'request' => $request->all(),
        ], 200);
    }

    public function receive(Request $request)
    {
        $req_finance = RequestFinance::find($request->requestAdvance['id']);
        $req_finance->status = 3;
        $req_finance->save();

        $inout = InOutPayment::where('finance_request_id', $req_finance->id)->first();
        $inout->status = 3;
        $inout->save();

        $req_finance_detail = RequestFinanceDetail::where('request_finance_id', $req_finance->id)->get();

        foreach ($request->detail as $value) {
            foreach ($req_finance_detail as $detail) {
                if ($value['id'] == $detail->id) {
                    $detail->pph = $value['pph'];
                    $detail->total = $value['total'];
                    $detail->updated_at = Carbon::now();
                    $detail->save();
                }
            }
        }

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    public function generateNoFile()
    {
        $year_month = Carbon::now()->format('ym');
        $get_last_inout_no = 'INOUT'.$year_month.'00000';
        $cut_string_inout = str_replace('INOUT', '', $get_last_inout_no);

        $latest_inout_payment = InOutPayment::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();

        return 'INOUT'.($cut_string_inout + ($latest_inout_payment['id'] + 1));
    }

    public function getNoVoucher($id)
    {
        $inOut = InOutPayment::find($id);

        return $inOut->no_voucher;
    }

    public function generateNoVoucher($type_transaction)
    {
        $year_month = Carbon::now()->format('ym');
        $month = Carbon::now()->format('m');
        $year = Carbon::now()->format('Y');

        if ($type_transaction == 1) {
            // code...
            $latest_voucher = InOutPayment::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->where('no_voucher', 'like', '%/BTS/RV/%')->latest()->first();
            $get_last_voucher_no = isset($latest_voucher->no_voucher) ? $latest_voucher->no_voucher : '0000/BTS/RV/'.$month.'/'.$year;
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

            return $string_voucher.'/BTS/RV/'.$month.'/'.$year;
        } else {
            // code...
            $latest_voucher = InOutPayment::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->where('no_voucher', 'like', '%/BTS/PV/%')->latest()->first();
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
}
