<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Finance\RekapInvoiceResource;
use App\Model\Finance\InvoiceOrder;
use App\Model\Marketing\SalesOrder;
use App\Model\MasterData\Customer;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InvoiceAPIController extends Controller
{
    public function printRecap($customer_id)
    {
        if (request()->isMethod('POST')) {
            InvoiceOrder::where('customer_id', $customer_id)->update(['is_recap' => 1]);
        } else {
            return new RekapInvoiceResource(Customer::where('id', $customer_id)->whereHas('invoices', function ($q) {
                $q->where('is_recap', 0);
            })->first());
        }
    }

    public function store(Request $request)
    {
        $rules = [
            'invoice_date' => 'required',
            'do_id' => 'required',
            'customer_id' => 'required'
        ];

        $request->validate($rules);

        $so_id = $request->so_id;
        $invoice_order = [
            'do_id' => $request->do_id,
            'user_id' => $request->user_id,
            'customer_id' => $request->customer_id,
            'invoice_date' => $request->invoice_date,
            'invoice_no' => $this->generateInvoiceNo(),
            'created_by' => $request->user_id
        ];
        InvoiceOrder::create($invoice_order);
        SalesOrder::find($so_id)->update(['status' => 6]);

        return response()->json([
            'status' => 'success'
        ], 200);
    }
        public function generateInvoiceNo()
    {
        $year_month = Carbon::now()->format('ym');
        $latest_invoice_order = InvoiceOrder::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        $get_last_inv_no = isset($latest_invoice_order->invoice_no) ? $latest_invoice_order->invoice_no : 'INV' . $year_month . '00000';
        $cut_string_inv_no = str_replace("INV", "", $get_last_inv_no);
        return 'INV' . ($cut_string_inv_no + 1);
    }
}
