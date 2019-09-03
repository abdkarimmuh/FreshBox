<?php

namespace App\Http\Controllers\API;

use App\Model\MasterData\SourceOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SourceOrderAPIController extends Controller
{
    public function all()
    {
        return SourceOrder::all();
    }
}
