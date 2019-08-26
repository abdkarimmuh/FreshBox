<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class UomController extends Controller
{
    public function index(Request $request)
    {
        $now = Carbon::now();
        DB::select('call insert_uom(?, ?, ?)', array($request->name, $request->description, $request->created_by));
    }
}
