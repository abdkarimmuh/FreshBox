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

    public function show($customer_id, $skuid, $fulfillment_date, Request $request)
    {
        $fulfillment_date = Carbon::create($fulfillment_date)->format('Y-m-d');

        $customer = Customer::find($customer_id);
        $data = PriceGroupCust::where('customer_group_id', $customer->customer_group_id)
            ->where('skuid', $skuid)
            ->where('start_periode', '<=', $fulfillment_date)
            ->where('end_periode', '>=', $fulfillment_date)->first();

        return new PriceResource($data);
    }

    public function CustomerPrice($id, $date)
    {
        $fulfillment_date = Carbon::create($date)->format('Y-m-d');

        $customer = Customer::find($id);

        $data = PriceGroupCust::where('customer_group_id', $customer->customer_group_id)
            ->where('start_periode', '<=', $fulfillment_date)
            ->where('end_periode', '>=', $fulfillment_date)
            ->get();

        if (isset($data)) {
            $price = PriceResource::collection($data);

            return response()->json(
                [
                    'status' => 'success',
                    'price' => $price,
                    'fulfillment_date' => $fulfillment_date,
                    'customer' => $customer,
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
