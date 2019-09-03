<?php

namespace App\Http\Controllers\API;

use App\Model\MasterData\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerAPIController extends Controller
{
    public function all()
    {
        return Customer::all();
    }
}
