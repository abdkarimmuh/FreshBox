<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Model\FinanceAP\TopUpProc;
use App\UserProc;
use Illuminate\Http\Request;

class TopUpController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchValue = $request->input('search');

        $columns = [
            array('title' => 'Action', 'field' => 'user_name'),
            array('title' => 'Tanggal Pengajuan', 'field' => 'date'),
            array('title' => 'User Procurement', 'field' => 'user_name'),
            array('title' => 'Amount', 'field' => 'amount', 'type' => 'price'),
            array('title' => 'Status', 'field' => 'status_name', 'type' => 'html'),
            array('title' => 'Remarks', 'field' => 'remark'),
        ];

        $config = [
            //Title Required
            'title' => 'TopUp Procurement',
            /*
             * Route Can Be Null
             */
            'route-approve-topup' => 'admin.financeAP.topup.approve',
            'route-reject-topup' => 'admin.financeAP.topup.reject',
            'route-search' => 'admin.financeAP.topup.index',
        ];

        $query = TopUpProc::dataTableQuery($searchValue)->orderBy('status', 'asc');
        $data = $query->paginate(10);

        return view('admin.crud.index', compact('columns', 'data', 'config'));
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

    public function approve($id)
    {
        $topUp = TopUpProc::find($id);

        if ($topUp->status == 1) {
            $topUp->status = 2;
            $topUp->save();

            $userProc = UserProc::find($topUp->user_proc_id);
            $userProc->saldo = intval($userProc->saldo) + $topUp->amount;
            $userProc->save();
        }

        return redirect('admin/finance-ap/topup');
    }

    public function reject($id)
    {
        $topUp = TopUpProc::find($id);

        if ($topUp->status == 1) {
            $topUp->status = 3;
            $topUp->save();
        }

        return redirect('admin/finance-ap/topup');
    }
}
