<?php

namespace App\Http\Controllers\ApiV1\WarehouseIn;

use App\Http\Controllers\Controller;
use App\Model\WarehouseIn\Confirm;
use Illuminate\Http\Request;

class ConfirmItemsAPIController extends Controller
{
    public function index()
    {
        $query = Confirm::all();
    }


}
