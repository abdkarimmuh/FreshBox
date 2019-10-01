<?php

namespace App\Http\Controllers\API;

use App\Http\Resources\Finance\RekapInvoiceResource;
use App\Http\Resources\MasterData\CustomerResource;
use App\Model\MasterData\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerAPIController extends Controller
{
    public function all()
    {
        return Customer::all();
    }

    public function ListCustomerHasRecap()
    {
        return CustomerResource::collection(Customer::whereHas('invoices', function ($q) {
            $q->where('is_recap', 0);
        })->get());
    }
}
