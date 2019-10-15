<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Finance\InvoiceRecapResource;
use App\Model\Finance\InvoiceRecap;
use Illuminate\Http\Request;

class InvoiceRecapAPIController extends Controller
{
    public function index(Request $request)
    {
        $recap_invoices = InvoiceRecap::IsNotPaid()->get();

        return InvoiceRecapResource::collection($recap_invoices);
    }

    public function show($id)
    {
        $recap_invoice = InvoiceRecap::findOrFail($id);

        return new InvoiceRecapResource($recap_invoice);
    }
}
