<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Model\Finance\RecapInvoice;
use Illuminate\Http\Request;

class InvoiceRecapAPIController extends Controller
{
    public function index(Request $request)
    {

    }

    public function show($id)
    {
        $recap_invoice = RecapInvoice::findOrFail($id);

        return response()->json([
            'status' => 'success',
            'data' => $recap_invoice
        ], 200);
    }
}
