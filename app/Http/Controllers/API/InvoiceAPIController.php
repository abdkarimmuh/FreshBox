<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\Finance\RekapInvoiceResource;
use App\Model\Finance\InvoiceOrder;
use App\Model\MasterData\Customer;
use Illuminate\Http\Request;

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
}
