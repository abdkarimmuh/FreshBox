<?php

namespace App\Http\Controllers\API;

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
        $query = InvoiceRecap::IsNotPaid();
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
}
