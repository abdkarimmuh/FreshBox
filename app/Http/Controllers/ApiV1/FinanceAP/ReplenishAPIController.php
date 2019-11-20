<?php

namespace App\Http\Controllers\ApiV1\FinanceAP;

use App\Http\Controllers\Controller;
use App\Model\FinanceAP\Replenish;
use App\Model\Procurement\ListProcurement;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReplenishAPIController extends Controller
{
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;
        $query = Replenish::dataTableQuery($searchValue);
        if ($request->start && $request->end) {
            $query->whereHas('procurement', function ($q) use($request) {
                $q->whereBetween('procurement_no', [$request->start, $request->end]);
            });
        }
        if ($searchValue) {
            $query = $query->take(20)->paginate(20);
        } else {
            $query = $query->paginate($perPage);
        }

        return SalesOrderResource::collection($query);
    }

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
