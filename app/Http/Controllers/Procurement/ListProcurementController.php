<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Model\Marketing\SalesOrderDetail;
use App\Model\Procurement\AssignListProcurementDetail;
use App\Model\Procurement\AssignProcurement;
use App\Model\Procurement\ListProcurement;
use App\Model\Procurement\ListProcurementDetail;
use App\Model\WarehouseIn\Confirm;
use App\UserProc;
use Illuminate\Http\Request;

class ListProcurementController extends Controller
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
            array('title' => 'Procurement No', 'field' => 'procurement_no'),
            array('title' => 'User Procurement', 'field' => 'proc_name'),
            array('title' => 'Vendor', 'field' => 'vendor'),
            array('title' => 'Amount', 'field' => 'total_amount', 'type' => 'price'),
            array('title' => 'Payment', 'field' => 'payment'),
            array('title' => 'Status', 'field' => 'status_name', 'type' => 'html'),
        ];

        $config = [
            //Title Required
            'title' => 'List Procurement',
            /*
             * Route Can Be Null
             */
            //Route For Button Edit
            'route-view' => 'admin.procurement.list_procurement.show',
            //Route For Button Search
            'route-search' => 'admin.procurement.list_procurement.index',
            //Route For Button Action Return
            'route-action-return' => 'admin.procurement.list_procurement.editReject',
        ];

        $query = ListProcurement::dataTableQuery($searchValue)->orderBy('created_at', 'desc');
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
        $data = ListProcurement::findOrFail($id);
        $detail = ListProcurementDetail::where('trx_list_procurement_id', $id)->get();

        $columns = [
            array('title' => 'Procurement No', 'field' => 'procurement_no'),
            array('title' => 'User Procurement', 'field' => 'proc_name'),
            array('title' => 'Vendor', 'field' => 'vendor'),
            array('title' => 'Amount', 'field' => 'total_amount', 'type' => 'price'),
            array('title' => 'Payment', 'field' => 'payment'),
            array('title' => 'Status', 'field' => 'status_name'),
            array('title' => 'Remarks', 'field' => 'remarks'),
        ];

        $detailColumns = [
            array('title' => 'Item', 'field' => 'item_name'),
            array('title' => 'Qty', 'field' => 'qty'),
            array('title' => 'Qty Minus', 'field' => 'qty_minus'),
            array('title' => 'Uom', 'field' => 'uom_name'),
            array('title' => 'Amount', 'field' => 'amount', 'type' => 'price'),
            array('title' => 'Status', 'field' => 'status_name'),
        ];

        $config = [
            //Title Required
            'title' => 'Detail',

            //Route For Button Back
            'back-button' => 'admin.procurement.list_procurement.index',
        ];

        return view('admin.crud.detail', compact('data', 'detail', 'config', 'columns', 'detailColumns'));
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

    public function editReject($id)
    {
        //Form Generator
        $forms = [
            array('type' => 'number', 'label' => 'Change Total Amount', 'name' => 'total_amount', 'place_holder' => 'Change Total Amount', 'mandatory' => true),
        ];
        $config = [
            //Form Title
            'title' => 'Reject Procurement',
            //Form Action Using Route Name
            'action' => 'admin.procurement.list_procurement.updateReject',
            //Form Method
            'method' => 'PATCH',
            //Back Button Using Route Name
            'back-button' => 'admin.procurement.list_procurement.index',
        ];

        $data = ListProcurement::findOrFail($id);
        $detail = ListProcurementDetail::where('trx_list_procurement_id', $id)->get();

        $columns = [
            array('title' => 'Procurement No', 'field' => 'procurement_no'),
            array('title' => 'User Procurement', 'field' => 'proc_name'),
            array('title' => 'Amount', 'field' => 'total_amount', 'type' => 'price'),
            array('title' => 'Status', 'field' => 'status_name'),
        ];

        $detailColumns = [
            array('title' => 'Item', 'field' => 'item_name'),
            array('title' => 'Qty', 'field' => 'qty'),
            array('title' => 'Qty Minus', 'field' => 'qty_minus'),
            array('title' => 'Uom', 'field' => 'uom_name'),
            array('title' => 'Amount', 'field' => 'amount', 'type' => 'price'),
            array('title' => 'Status', 'field' => 'status_name'),
        ];

        return view('admin.crud.create_or_edit', compact('forms', 'config', 'data', 'detail', 'columns', 'detailColumns'));
    }

    public function updateReject(Request $request)
    {
        $request->validate([
            'total_amount' => 'required',
        ]);

        $listProcurement = ListProcurement::find($request->id);
        $confirm = Confirm::where('list_procurement_id', $listProcurement->id)->first();

        $user_proc = UserProc::find($listProcurement->user_proc_id);
        $saldo = $user_proc->saldo;
        $user_proc->saldo = $saldo + $request->total_amount;
        $user_proc->save();

        $listProcurement->total_amount = $request->total_amount;
        $listProcurement->status = 2;
        $listProcurement->save();

        $confirm->status = 1;
        $confirm->save();

        $listProcurementDetail = ListProcurementDetail::where('trx_list_procurement_id', $listProcurement->id)->get();

        foreach ($listProcurementDetail as $item) {
            $assignListProcurementDetail = AssignListProcurementDetail::where('list_procurement_detail_id', $item->id)->first();

            $assignProcurement = AssignProcurement::find($assignListProcurementDetail->assign_id);
            $soDetail = SalesOrderDetail::find($assignProcurement->sales_order_detail_id);

            $item->status = 2;
            $item->save();

            $sisaQtyProc = $soDetail->sisa_qty_proc + $item->qty_minus;
            $soDetail->sisa_qty_proc = $sisaQtyProc;
            $soDetail->save();
        }

        return redirect('admin/procurement/list_procurement');
    }
}
