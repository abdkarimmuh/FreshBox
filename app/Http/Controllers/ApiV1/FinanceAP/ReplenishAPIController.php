<?php

namespace App\Http\Controllers\ApiV1\FinanceAP;

use App\Http\Controllers\Controller;
use App\Model\FinanceAP\Replenish;
use App\Model\Procurement\ListProcurement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReplenishAPIController extends Controller
{
    /**
     *Insert the replenish data
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        $data = [
            'status' => $request->status,
            'total_amount' => $request->totalAmount,
            'list_proc_id' => $request->listProcId,
            'remark' => $request->remark
        ];
        Replenish::insert($data);
        if ($data['status'] === 1) {
            $status = 4;
            $proc = ListProcurement::findOrFail($data['list_proc_id']);
            $saldo = $proc->saldo + $data['total_amount'];
            $proc->update(['saldo' => $saldo]);
        } elseif ($data['status'] === 2) {
            $status = 5;
        }
        ListProcurement::findOrFail($data['list_proc_id'])->update(['status' => $status]);

        return response()->json([
            'status' => true
        ]);
    }
}
