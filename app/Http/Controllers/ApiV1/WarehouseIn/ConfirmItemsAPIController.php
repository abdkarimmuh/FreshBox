<?php

namespace App\Http\Controllers\ApiV1\WarehouseIn;

use App\Http\Controllers\Controller;
use App\Model\Marketing\SalesOrderDetail;
use App\Model\MasterData\Inventory;
use App\Model\Procurement\AssignListProcurementDetail;
use App\Model\Procurement\AssignProcurement;
use App\Model\Procurement\ListProcurement;
use App\Model\Procurement\ListProcurementDetail;
use App\Model\WarehouseIn\Confirm;
use App\Model\WarehouseIn\ConfirmDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ConfirmItemsAPIController extends Controller
{
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;
        $query = Confirm::dataTableQuery($searchValue);
        if ($request->start && $request->end) {
            $query->whereBetween('sales_order_no', [$request->start, $request->end]);
        }
        if ($searchValue) {
            $query = $query->orderBy('sales_order_no', 'desc')->take(20)->paginate(20);
        } else {
            $query = $query->orderBy('sales_order_no', 'desc')->paginate($perPage);
        }

        return SalesOrderResource::collection($query);
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
            'created_at' => Carbon::now(),
        ];

        $minus = 0;

        $confirm_id = Confirm::insertGetId($data);

        $listProcurement = ListProcurement::find($data['list_procurement_id']);

        if (substr($listProcurement->procurement_no, -1) == 'R') {
            $procurementNo = $listProcurement->procurement_no;
            $no = str_replace('PROC', '', $procurementNo);
            $noR = str_replace('R', '', $no);
            $procNo = 'PROC'.$noR;

            $listProcurementParent = ListProcurement::where('procurement_no', $procNo)->first();

            $listProcurementParent->status = 2;
            $listProcurementParent->save();

            $confirmParent = Confirm::where('list_procurement_id', $listProcurementParent->id)->first();
            $confirmParent->status = 1;
            $confirmParent->save();
        }

        ListProcurement::find($data['list_procurement_id'])->update(['status' => 2]);

        foreach ($request->items as $i => $item) {
            if ($item['qty_minus'] != 0) {
                $minus = $minus + 1;
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
                Confirm::find($confirm_id)->update(['status' => 2]);
                ListProcurement::find($data['list_procurement_id'])->update(['status' => 3]);
                $this->insertInventory($item['id'], $item['netto']);
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

                $listProcurementDetail = ListProcurementDetail::find($item['id']);
                $assignListProcurementDetail = AssignListProcurementDetail::where('list_procurement_detail_id', $listProcurementDetail->id)->first();
                $assignProcurement = AssignProcurement::find($assignListProcurementDetail['assign_id']);
                $salesOrderDetail = SalesOrderDetail::find($assignProcurement['sales_order_detail_id']);
                $salesOrderDetail->status = 4;
                $salesOrderDetail->save();

                $this->insertInventory($item['id'], $item['netto']);
            }
        }
        if ($minus > 0) {
            DB::select('call insert_notification_procurement(?, ?, ?)', array($userProcId, $confirm_id, 1));
        }

        return response()->json(['status' => 'success'], 200);
    }

    public function insertInventory($procDetailId, $qty)
    {
        $userId = auth('api')->user()->id;
        $now = Carbon::now();

        $procurement = ListProcurementDetail::findOrFail($procDetailId);

        $skuid = $procurement->skuid;

        $inventory = Inventory::where('skuid', $skuid)->first();

        if (isset($inventory)) {
            $qty_inventory = $inventory->qty + $qty;

            $inventory->qty = $qty_inventory;
            $inventory->updated_at = $now;
            $inventory->updated_by = $userId;

            $inventory->save();
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
