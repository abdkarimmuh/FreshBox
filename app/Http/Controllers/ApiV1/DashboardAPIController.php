<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Model\Marketing\SalesOrder;

class DashboardAPIController extends Controller
{
    public function all()
    {
        $totalOrder = SalesOrder::all();
        $submittedInvoice = SalesOrder::where('status', 6)->get();
        $paidInvoice = SalesOrder::where('status', 8)->get();

        return response()->json([
            'totalOrder' => $totalOrder->count(),
            'submittedInvoice' => $submittedInvoice->count(),
            'paidInvoice' => $paidInvoice->count(),
        ]);
    }
}
