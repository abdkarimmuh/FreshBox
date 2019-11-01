<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Resources\DataCollectionResource;
use App\Http\Resources\MasterData\PriceResource;
use App\Model\MasterData\Price;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class MasterPriceController extends Controller
{
    public function index(Request $request)
    {
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $orderBy = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $query = Price::dataTableQuery($column, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataCollectionResource($data);
    }

    public function show($customer_id, $skuid, Request $request)
    {
        $data = Price::where('customer_id', $customer_id)->where('skuid', $skuid)->first();
        return new PriceResource($data);
    }

    public function CustomerPrice($id, Request $request)
    {
        $fulfillment_date = Carbon::create($request->fulfillment_date)->format('Y-m-d');

        $data = Price::where('customer_id', $id)
            ->where('start_periode', '<=', $fulfillment_date)
            ->where('end_periode', '>=', $fulfillment_date)
            ->get();
        if (isset($data)) {
            $data = PriceResource::collection($data);
            return response()->json(
                [
                    'status' => 'success',
                    'data' => $data
                ],
                200
            );
        } else {
            return response()->json(
                [
                    'status' => 'fails',
                ],
                200
            );
        }
    }
}