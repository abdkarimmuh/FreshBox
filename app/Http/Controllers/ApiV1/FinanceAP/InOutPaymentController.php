<?php

namespace App\Http\Controllers\ApiV1\FinanceAP;

use App\Http\Controllers\Controller;
use App\Http\Resources\FinanceAp\InOutPaymentResource;
use App\Http\Resources\FinanceAP\RequestFinanceResource;
use App\Model\FinanceAp\InOutPayment;
use App\Model\FinanceAP\RequestFinance;
use Illuminate\Http\Request;

class InOutPaymentController extends Controller
{
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;
        $query = InOutPayment::dataTableQuery($searchValue);
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
}
