<?php

namespace App\Http\Controllers\ApiV1;

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
