<?php

namespace App\Http\Controllers\ApiV1\WarehouseIn;

use App\Http\Controllers\Controller;
use App\Model\Procurement\ListProcurement;
use App\Model\Procurement\ListProcurementDetail;
use App\Model\WarehouseIn\Confirm;
use App\Model\WarehouseIn\ConfirmDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfirmItemsAPIController extends Controller
{
    public function index()
    {
        return Confirm::all();
    }

    public function store(Request $request)
    {
        //List Validasi
        $rules = [
            'procurementId' => 'required',
            'items' => 'required',
            'items.*.bruto' => 'required',
            'items.*.netto' => 'required',
            'items.*.tara' => 'required'
        ];
        $request->validate($rules);
        $userId = auth('api')->user()->id;
        $userProcId = $request->userProcId;
        $data = [
            'list_procurement_id' => $request->procurementId,
            'remark' => $request->remark,
            'status' => 1,
            'created_by' => $userId
        ];

        $confirm_id = Confirm::insertGetId($data);

        foreach ($request->items as $i => $item) {
            if ($item['qty_minus'] != 0) {
                ListProcurementDetail::find($item['id'])->update(
                    [
                        'status' => 3,
                        'qty_minus' => $item['qty_minus']
                    ]
                );
                ConfirmDetail::insertGetId(
                    [
                        'warehouse_confirm_id' => $confirm_id,
                        'list_proc_detail_id' => $item['id'],
                        'bruto' => $item['bruto'],
                        'netto' => $item['netto'],
                        'created_by' => $userId
                    ]);

                DB::select('call insert_notification_procurement(?, ?, ?, ?)', array($userProcId, $confirm_id, 1, $data['remark']));
            } else {
                ListProcurementDetail::find($item['id'])->update(
                    [
                        'status' => 2,
                    ]
                );
                ConfirmDetail::insert(
                    [
                        'warehouse_confirm_id' => $confirm_id,
                        'list_proc_detail_id' => $item['id'],
                        'bruto' => $item['bruto'],
                        'netto' => $item['netto'],
                        'created_by' => $userId
                    ]);
            }
        }
        ListProcurement::find($data['list_procurement_id'])->update(['status' => 2]);
        return response()->json([
            'status' => 'success',
        ], 200);
    }

}
