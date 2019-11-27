<?php

namespace App\Http\Controllers\ApiV1\WarehouseIn;

use App\Http\Controllers\Controller;
use App\Model\MasterData\Inventory;
use App\Model\Procurement\ListProcurement;
use App\Model\Procurement\ListProcurementDetail;
use App\Model\WarehouseIn\Confirm;
use App\Model\WarehouseIn\ConfirmDetail;
use Carbon\Carbon;
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
        ];
        $request->validate($rules);
        $userId = auth('api')->user()->id;
        $proc = ListProcurement::find($request->procurementId);
        $userProcId = $proc->user_proc_id;

        $data = [
            'list_procurement_id' => $request->procurementId,
            'remark' => $request->remark,
            'status' => 1,
            'created_by' => $userId,
        ];

        $confirm_id = Confirm::insertGetId($data);

        foreach ($request->items as $i => $item) {
            if ($item['qty_minus'] != 0) {
                ListProcurementDetail::find($item['id'])->update([
                    'status' => 3,
                    'qty_minus' => $item['qty_minus'],
                ]);
                ConfirmDetail::insertGetId([
                    'warehouse_confirm_id' => $confirm_id,
                    'list_proc_detail_id' => $item['id'],
                    'bruto' => $item['bruto'],
                    'netto' => $item['netto'],
                    'created_by' => $userId,
                    'created_at' => Carbon::now(),
                ]);
                DB::select('call insert_notification_procurement(?, ?, ?)', array($userProcId, $confirm_id, 1));
            } else {
                ListProcurementDetail::find($item['id'])->update([
                    'status' => 2,
                ]);
                ConfirmDetail::insert([
                    'warehouse_confirm_id' => $confirm_id,
                    'list_proc_detail_id' => $item['id'],
                    'bruto' => $item['bruto'],
                    'netto' => $item['netto'],
                    'created_by' => $userId,
                    'created_at' => Carbon::now(),
                ]);
            }
            $this->insertInventory($item['id'], $item['netto']);
        }
        ListProcurement::find($data['list_procurement_id'])->update(['status' => 2]);

        return response()->json([
            'status' => 'success',
        ], 200);
    }

    public function insertInventory($procDetailId, $qty)
    {
        $userId = auth('api')->user()->id;
        $now = Carbon::now();

        $procurement = ListProcurementDetail::where('trx_list_procurement_id', $procDetailId);
        $skuid = $procurement->skuid;

        $inventory = Inventory::where('skuid', $skuid);

        if (isset($inventory)) {
            $qty_inventory = $inventory->qty + $qty;

            $inventory->qty = $qty_inventory;
            $inventory->updated_at = $now;
            $inventory->updated_by = $userId;
        } else {
            Inventory::insert([
                'skuid' => $skuid,
                'qty' => $qty,
                'created_by' => $userId,
                'created_at' => $now,
            ]);
        }
    }
}
