<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Resources\DataCollectionResource;
use App\Http\Resources\MasterData\PriceResource;
use App\Model\MasterData\Price;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MasterData\Customer;
use App\Model\MasterData\PriceGroupCust;

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

    public function getPrice(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;

        $month = Carbon::now()->subMonth(2)->format('y-m-d');
        $now = Carbon::now()->format('y-m-d');

        $query = PriceGroupCust::where('end_periode', '>', $now)->where('start_periode', '>', $month)->dataTableQuery($searchValue);
        if ($searchValue) {
            $query = $query->take(10)->paginate(10);
        } else {
            $query = $query->paginate($perPage);
        }

        return new DataCollectionResource($query);
    }

    public function show($customer_id, $skuid, Request $request)
    {
        $customer = Customer::find($customer_id);
        $data = PriceGroupCust::where('customer_group_id', $customer->customer_group_id)->where('skuid', $skuid)->first();

        return new PriceResource($data);
    }

    public function CustomerPrice($id, Request $request)
    {
        $fulfillment_date = Carbon::create($request->fulfillment_date)->format('Y-m-d');

        // return response()->json(
        //     [
        //         'fulfillment_date' => $fulfillment_date,
        //     ],
        //     200
        // );

        $customer = Customer::find($id);

        $data = PriceGroupCust::where('customer_group_id', $customer->customer_group_id)
            ->where('start_periode', '<=', $fulfillment_date)
            ->where('end_periode', '>=', $fulfillment_date)
            ->get();
        if (isset($data)) {
            $data = PriceResource::collection($data);

            return response()->json(
                [
                    'status' => 'success',
                    'data' => $data,
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
