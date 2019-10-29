<?php

namespace App\Http\Controllers\ApiV1\Finance;

use App\Http\Controllers\Controller;
use App\Http\Resources\Finance\InvoiceRecapHasDetailResource;
use App\Http\Resources\Finance\InvoiceRecapResource;
use App\Model\Finance\InvoiceRecap;
use Illuminate\Http\Request;

class InvoiceRecapAPIController extends Controller
{
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;
        if ($request->status === 'submitted') {
            $query = InvoiceRecap::IsNotPaid()->isSubmitted();
        } elseif ($request->status === 'paid') {
            $query = InvoiceRecap::isPaid()->isSubmitted();
        } else {
            $query = InvoiceRecap::IsNotPaid()->isNotSubmitted();
        }

        if ($request->start && $request->end) {
            $query->whereBetween('recap_invoice_no', [$request->start, $request->end]);
        }
        if ($searchValue) {
            $query = $query->orderBy('recap_invoice_no', 'desc')->take(20)->paginate(20);
        } else {
            $query = $query->orderBy('recap_invoice_no', 'desc')->paginate($perPage);
        }
        return InvoiceRecapResource::collection($query);
    }

    public function show($id)
    {
        $recap_invoice = InvoiceRecap::findOrFail($id);

        return new InvoiceRecapHasDetailResource($recap_invoice);
    }

    public function StoreSubmitInvoice(Request $request)
    {
        $rules = [
            'submitDate' => 'required',
            'recapInvoiceId' => 'required'
        ];
        $request->validate($rules);
        $recapInvoice = InvoiceRecap::find($request->recapInvoiceId)
            ->update([
                'submitted_date' => $request->submitDate
            ]);

        return $this->sendResponse($recapInvoice, 'Recap Invoice submitted successfully.');

    }

    public function InvoiceNotSubmitted()
    {
        return InvoiceRecapResource::collection(InvoiceRecap::IsNotPaid()->isNotSubmitted()->get());
    }

    public function InvoiceSubmitted()
    {
        return InvoiceRecapResource::collection(InvoiceRecap::IsNotPaid()->isSubmitted()->get());
    }

    public function InvoicePaid()
    {
        return InvoiceRecapResource::collection(InvoiceRecap::isSubmitted()->isPaid()->get());
    }
}
