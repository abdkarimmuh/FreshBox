<?php

namespace App\Http\Controllers\ApiV1\FinanceAP;

use App\Http\Controllers\Controller;
use App\Http\Resources\FinanceAP\SettlementFinanceResource;
use App\Http\Resources\FinanceAP\SettlementWithDetailResource;
use App\Model\FinanceAP\RequestFinance;
use App\Model\FinanceAP\RequestFinanceDetail;
use App\Model\FinanceAP\Settlement;
use App\Model\FinanceAP\SettlementDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class SettlementFinanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;
        $query = Settlement::dataTableQuery($searchValue);
        if ($request->start && $request->end) {
            $query->whereBetween('no_settlement', [$request->start, $request->end]);
        }
        if ($searchValue) {
            $query = $query->orderBy('no_settlement', 'desc')->take(20)->paginate(20);
        } else {
            $query = $query->orderBy('no_settlement', 'desc')->paginate($perPage);
        }

        return SettlementFinanceResource::collection($query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $rules = [
            'requestId' => 'required',
            'items' => 'required',
            'items.*.qty_confirm' => 'required|not_in:0',
            'items.*.price_confirm' => 'required|not_in:0',
            'items.*.total_confirm' => 'required|not_in:0',
        ];
        $request->validate($rules);

        //Untuk Mengupload File Ke Storage
        if ($request->file) {
            $file = $request->file;
            @list($type, $file_data) = explode(';', $file);
            @list(, $file_data) = explode(',', $file_data);
            $file_name = $this->generateSettlementNo().'.'.explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            Storage::disk('local')->put('public/files/settlement/'.$file_name, base64_decode($file_data), 'public');
        } else {
            $file_name = '';
        }

        $data = [
            'request_finance_id' => $request->requestId,
            'status' => 1,
            'no_settlement' => $this->generateSettlementNo(),
            'file' => $file_name,
            'remarks' => $request->remarks,
            'created_at' => Carbon::now(),
            'created_by' => auth('api')->user()->id,
        ];

        $settlement = Settlement::insertGetId($data);
        $items = $request->items;

        $requestDetail = RequestFinanceDetail::where('request_finance_id', $request->requestId)->get();

        $total_confirm = 0;
        $total = 0;

        foreach ($items as $i => $detail) {
            $settlementFinanceDetails[] = [
                'settlement_id' => $settlement,
                'item_name' => $requestDetail[$i]->item_name,
                'skuid' => $requestDetail[$i]->skuid,
                'qty' => $detail['qty_confirm'],
                'uom_id' => $requestDetail[$i]->uom_id,
                'price' => $detail['price_confirm'],
                'ppn' => $requestDetail[$i]->ppn,
                'total' => $detail['total_confirm'],
                'supplier_id' => $requestDetail[$i]->supplier_id,
                'created_at' => now(),
            ];

            $total_confirm = $total_confirm + ($detail['total_confirm']);
            $total = $total + ($requestDetail[$i]->total);
        }
        SettlementDetail::insert($settlementFinanceDetails);

        if ($total == $total_confirm) {
            $statusSettlement = 1;
            $statusRequest = 5;
        } elseif ($total > $total_confirm) {
            // Remaining Money
            $statusSettlement = 2;
            $statusRequest = 6;
        } else {
            // Less Money
            $statusSettlement = 3;
            $statusRequest = 7;
        }

        $requestFinance = RequestFinance::find($request->requestId);
        $settlementAdvance = Settlement::find($settlement);

        $requestFinance->status = $statusRequest;
        $requestFinance->updated_at = Carbon::now();
        $requestFinance->save();

        $settlementAdvance->status = $statusSettlement;
        $settlementAdvance->updated_at = Carbon::now();
        $settlementAdvance->save();
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new SettlementWithDetailResource(Settlement::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }

    public function generateSettlementNo()
    {
        $year_month = Carbon::now()->format('ym');
        $latest_settlement = Settlement::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        $get_last_settlement_no = isset($latest_settlement->no_settlement) ? $latest_settlement->no_settlement : 'SET'.$year_month.'00000';
        $cut_string_settlement = str_replace('SET', '', $get_last_settlement_no);

        return 'SET'.($cut_string_settlement + 1);
    }
}
