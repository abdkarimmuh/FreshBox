<?php

namespace App\Http\Controllers\WarehouseIn;

use App\Http\Controllers\Controller;
use App\Model\WarehouseIn\Confirm;
use App\Model\WarehouseIn\ConfirmDetail;
use Illuminate\Http\Request;

class ConfirmController extends Controller
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
            array('title' => 'Remarks', 'field' => 'remarks'),
            array('title' => 'Status', 'field' => 'status_name', 'type' => 'html'),
            array('title' => 'Created By', 'field' => 'created_by'),
            array('title' => 'Created At', 'field' => 'created_at'),
        ];

        $config = [
            //Title Required
            'title' => 'Confirm Incoming Items',
            /*
             * Route Can Be Null
             */
            //Route For Button Add
            // 'route-add' => 'admin.warehouse_in.confirm.create',
            //Route For Button View
            //Route For Button Search
            'route-search' => 'admin.warehouseIn.confirm.index',
        ];

        $query = Confirm::dataTableQuery($searchValue);
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
        $data = Confirm::findOrFail($id);
        $detail = ConfirmDetail::where('trx_list_procurement_id', $id)->get();

        $columns = [
            array('title' => 'Procurement No', 'field' => 'procurement_no'),
            array('title' => 'User Procurement', 'field' => 'proc_name'),
            array('title' => 'Status', 'field' => 'status_name'),
            array('title' => 'Remarks', 'field' => 'remarks'),
        ];

        $detailColumns = [
            array('title' => 'Item', 'field' => 'item_name'),
            array('title' => 'Qty Procurement', 'field' => 'qty_proc'),
            array('title' => 'Uom', 'field' => 'uom_name'),
            array('title' => 'Bruto (Berat Kotor)', 'field' => 'bruto'),
            array('title' => 'Netto (Berat Bersih)', 'field' => 'netto'),
            array('title' => 'Tara (Potongan Berat)', 'field' => 'tara'),
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
}
