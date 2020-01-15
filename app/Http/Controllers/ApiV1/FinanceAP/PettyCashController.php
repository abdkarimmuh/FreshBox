<?php

namespace App\Http\Controllers\ApiV1\FinanceAP;

use App\Http\Controllers\Controller;
use App\Http\Resources\FinanceAP\PettyCashResource;
use App\Http\Resources\FinanceAP\RequestFinanceResource;
use App\Model\FinanceAP\PettyCash;
use App\Model\FinanceAP\RequestFinance;
use Illuminate\Http\Request;

class PettyCashController extends Controller
{
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;

        $query = PettyCash::dataTableQuery($searchValue);
        if ($searchValue) {
            $query = $query->take(20)->paginate(20);
        } else {
            $query = $query->paginate($perPage);
        }


        return PettyCashResource::collection($query);
    }

    public function show(Request $request)
    {
        if (is_array($request->id)) {
            $inv = PettyCash::whereIn('id', $request->id)->get();
            $pettycash = PettyCashResource::collection($inv);
        } elseif ($request->printAll == true) {
            $inv = PettyCash::where('is_printed', 0)->get();
            $pettycash = PettyCashResource::collection($inv);
        } else {
            $inv = PettyCash::findOrFail($request->id);
            $pettycash = new PettyCashResource($inv);
        }

        return response()->json($pettycash, 200);
    }
}
