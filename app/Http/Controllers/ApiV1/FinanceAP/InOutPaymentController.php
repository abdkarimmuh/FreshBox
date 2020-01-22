<?php

namespace App\Http\Controllers\ApiV1\FinanceAP;

use App\Http\Controllers\Controller;
use App\Http\Resources\FinanceAP\InOutPaymentResource;
use App\Model\FinanceAP\InOutPayment;
use App\Model\FinanceAP\RequestFinance;
use Illuminate\Http\Request;
use Carbon\Carbon;

class InOutPaymentController extends Controller
{
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;
        $query = InOutPayment::where('status', '>', 1)->dataTableQuery($searchValue);
        if ($searchValue) {
            $query = $query->take(20)->paginate(20);
        } else {
            $query = $query->paginate($perPage);
        }

        return InOutPaymentResource::collection($query);
    }

    public function show(Request $request)
    {
        if (is_array($request->id)) {
            $inv = InOutPayment::whereIn('id', $request->id)->get();
            $invoice_order = InOutPaymentResource::collection($inv);
        } elseif ($request->printAll == true) {
            $inv = InOutPayment::where('is_printed', 0)->get();
            $invoice_order = InOutPaymentResource::collection($inv);
        } else {
            $inv = InOutPayment::findOrFail($request->id);
            $invoice_order = new InOutPaymentResource($inv);
        }

        return response()->json($invoice_order, 200);
    }

    public function store(Request $request)
    {
        $rules = [
            'source' => 'required',
            'bank_id' => 'required',
            'no_rek' => 'required',
            'type_transaction' => 'required',
            'transaction_date' => 'required',
            'amount' => 'required',

        ];

        $request->validate($rules);

        $in_out_payment = [
            'source' => $request->source,
            'bank_id' => $request->bank_id,
            'no_rek' => $request->no_rek,
            'type_transaction' => $request->type_transaction,
            'transaction_date' => $request->transaction_date,
            'amount' => $request->amount,
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
}
