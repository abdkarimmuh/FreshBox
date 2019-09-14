<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MasterData\Driver;

class DriverAPIController extends Controller
{
    public function index()
    {
        return Driver::all();
    }
}
