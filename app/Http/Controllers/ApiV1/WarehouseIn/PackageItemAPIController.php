<?php

namespace App\Http\Controllers\ApiV1\WarehouseIn;

use App\Http\Controllers\Controller;
use App\Model\Marketing\SalesOrderDetail;
use App\Model\Warehouse\DeliveryOrderDetail;
use Symfony\Component\HttpFoundation\Request;
use App\Http\Resources\Warehouse\PrintLabelResource;
use App\Http\Resources\Warehouse\PackageItemResource;

class PackageItemAPIController extends Controller
{
    /**
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;
        $query = DeliveryOrderDetail::dataTableQuery($searchValue);
        if ($searchValue) {
            $query = $query->take(20)->paginate(20);
        } else {
            $query = $query->paginate($perPage);
        }

        return PackageItemResource::collection($query);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function show(Request $request)
    {
        if (is_array($request->id)) {
            $doDetail = DeliveryOrderDetail::whereIn('id', $request->id)->orderBy('created_at', 'desc')->get();
            $print = PrintLabelResource::collection($doDetail);
        } else {
            $doDetail = DeliveryOrderDetail::findOrFail($request->id);
            $print = new PrintLabelResource($doDetail);
        }

        return response()->json($print, 200);
    }

    public function print(Request $request)
    {
    }
}
