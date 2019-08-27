<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class UomController extends Controller
{
    public function store(Request $request)
    {
        DB::select('call insert_uom(?, ?, ?)', array($request->name, $request->description, $request->created_by));
    }
}
