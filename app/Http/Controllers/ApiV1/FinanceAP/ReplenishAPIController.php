<?php

namespace App\Http\Controllers\ApiV1\FinanceAP;

use App\Http\Controllers\Controller;
use App\Http\Resources\FinanceAP\ReplenishResource;
use App\Model\FinanceAP\Replenish;
use App\Model\Procurement\ListProcurement;
use App\Model\WarehouseIn\Confirm;
use App\UserProc;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReplenishAPIController extends Controller
{
    /**
     * List Data Replenish.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;
        $query = Replenish::dataTableQuery($searchValue);
        if ($request->start && $request->end) {
            $query->whereHas('procurement', function ($q) use ($request) {
                $q->whereBetween('procurement_no', [$request->start, $request->end]);
            });
        }
        if ($searchValue) {
            $query = $query->take(20)->paginate(20);
        } else {
            $query = $query->paginate($perPage);
        }

        return ReplenishResource::collection($query);
    }

    /**
     *Insert the replenish data.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'status' => 'required|not_in:0',
            'totalAmount' => 'required',
            'listProcId' => 'required',
        ]);

        $data = [
            'userProcId' => intval($request->userProcId),
            'status' => intval($request->status),
            'total_amount' => $request->totalAmount,
            'list_proc_id' => $request->listProcId,
            'remark' => $request->remark,
            'created_by' => auth('api')->user()->id,
        ];

        Replenish::create($data);

        if ($data['status'] == 1) {
            $status = 4;

            $userProc = UserProc::find($data['userProcId']);
            $saldo = $userProc->saldo + $data['total_amount'];
            $userProc->saldo = $saldo;
            $userProc->save();

            $confirm = Confirm::where('list_procurement_id', $request->listProcId)->first();
            $confirm->status = 3;
            $confirm->save();
        } elseif ($data['status'] == 2) {
            $status = 5;

            $confirm = Confirm::where('list_procurement_id', $request->listProcId)->first();
            $confirm_id = $confirm->id;

            DB::select('call insert_notification_procurement(?, ?, ?)', array(intval($request->userProcId), $confirm_id, 2));
        }

        ListProcurement::findOrFail($data['list_proc_id'])->update(['status' => $status]);

        return response()->json([
            'success' => true,
        ]);
    }

    /**
     * Change Status To Replenish.
     *
     * @param $id
     *
     * @return JsonResponse
     */
    public function replenish($id)
    {
        $replenish = Replenish::findOrFail($id);
        $replenish->status = 1;

        $listProcurement = ListProcurement::findOrFail($replenish->list_proc_id);
        $listProcurement->status = 4;

        $userProc = UserProc::find($replenish->created_by);
        $saldo = $userProc->saldo + $listProcurement->total_amount;
        $userProc->saldo = $saldo;

        $confirm = Confirm::where('list_procurement_id', $listProcurement->id)->first();
        $confirm->status = 3;

        $listProcurement->save();
        $replenish->save();
        $userProc->save();
        $confirm->save();

        return response()->json([
            'success' => true,
        ]);
    }
}
