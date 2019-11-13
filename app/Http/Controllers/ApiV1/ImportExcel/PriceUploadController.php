<?php

namespace App\Http\Controllers\ApiV1\ImportExcel;

use App\Http\Controllers\Controller;
use App\Imports\PriceTempImport;
use App\PriceTemp;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PriceUploadController extends Controller
{
    /**
     *
     */
    public function index()
    {
        $config = [
            'vue-component' => '<import-price-temp>'
        ];
        return view('layouts.vue-view', compact('config'));
    }

    /**
     * Insert Price Temp from Upload Excel
     * @param Request $request
     * @return Collection
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required',
            'customerGroupId' => 'required',
            'startPeriod' => 'required',
            'endPeriod' => 'required',
        ]);
        $data = [
            'startPeriod' => $request->startPeriod,
            'customerGroupId' => $request->customerGroupId,
            'endPeriod' => $request->endPeriod,
            'file' => $request->file,
        ];
        $array = Excel::toArray(new PriceTempImport(), $data['file']);
        return collect(head($array))->each(function ($row, $key) use ($data) {
            $exist = DB::table('price_temp')->where('sku', $row['sku'])->where('customer_group_id', $data['customerGroupId'])->get();
            if (count($exist) > 0) {
                PriceTemp::where('sku', $row['sku'])
                    ->where('customer_group_id', $data['customerGroupId'])
                    ->update([
                        'Pricelist' => $row['basicprice'],
                        'Discount' => $row['discount'],
                        'Final' => $row['price'],
                        'Remarks' => $row['remarks'],
                        'start_period' => $data['startPeriod'],
                        'End_Period' => $data['endPeriod'],
                        'AuditDate' => $row['audi_date'],
                    ]);
            } else {
                PriceTemp::insert([
                    'No' => $row['no'],
                    'Category' => $row['category'],
                    'SKU' => $row['sku'],
                    'Items' => $row['items'],
                    'Unit' => $row['unit'],
                    'Pricelist' => $row['basicprice'],
                    'Discount' => $row['discount'],
                    'Final' => $row['price'],
                    'Remarks' => $row['remarks'],
                    'customer_group_id' => $data['customerGroupId'],
                    'start_period' => $data['startPeriod'],
                    'End_Period' => $data['endPeriod'],
                    'AuditDate' => $row['audi_date'],
                ]);
            }
        });
    }
    /**
     * Generate Master Price
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateMasterPriceAll()
    {
        $generate = DB::select('call GeneMAsterPriceAll(?)',array(auth('api')->user()->id));
        if ($generate) {
            $status = true;
        } else {
            $status = false;
        }
        return response()->json([
            'success' => $status,
        ]);
    }
}
