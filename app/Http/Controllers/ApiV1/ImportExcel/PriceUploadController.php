<?php

namespace App\Http\Controllers\ApiV1\ImportExcel;

use App\Exports\ExportDuplicatePrice;
use App\Http\Controllers\Controller;
use App\Imports\PriceTempImport;
use App\PriceTemp;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class PriceUploadController extends Controller
{
    /**
     * Insert Price Temp from Upload Excel.
     *
     * @param Request $request
     *
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
        PriceTemp::truncate();
        $array = Excel::toArray(new PriceTempImport(), $data['file']);
        collect(head($array))->each(function ($row, $key) use ($data) {
            $exist = DB::table('price_temp')->where('sku', $row['sku'])->where('customer_group_id', $data['customerGroupId'])->get();
            if (count($exist) > 0) {
                PriceTemp::create([
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
                    'AuditDate' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
                PriceTemp::where('sku', $row['sku'])
                    ->where('customer_group_id', $data['customerGroupId'])
                    ->update([
                        'updated_at' => Carbon::now(),
                    ]);
            } else {
                PriceTemp::create([
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
                    'AuditDate' => Carbon::now(),
                    'updated_at' => null,
                ]);
            }
        });

        return response()->json([
            'success' => true,
            'duplicate' => PriceTemp::whereNotNull('updated_at')->get(),
        ]);
    }

    /**
     * Generate Master Price.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function generateMasterPriceAll()
    {
        DB::select('call GenGroupMasterPriceAll(?)', array(auth('api')->user()->id));

        return response()->json([
            'success' => true,
        ]);
    }

    public function exportDuplicateData()
    {
        $now = Carbon::now()->formatLocalized('%d-%B-%Y');

        return (new ExportDuplicatePrice())->download('Duplicate Price - '.$now.'.xlsx');
    }
}
