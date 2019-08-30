<?php

namespace App\Http\Controllers\MasterData;

use App\Model\MasterData\SourceOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SourceOrderController extends Controller
{
    public function index()
    {

    }

    /**
     * Api Source Order Without Pagination
     */
    public function all()
    {
      return SourceOrder::all();
    }
}
