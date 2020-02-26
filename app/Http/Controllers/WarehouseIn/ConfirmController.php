<?php

namespace App\Http\Controllers\WarehouseIn;

use App\Http\Controllers\Controller;
use App\Model\WarehouseIn\Confirm;
use App\Model\WarehouseIn\ConfirmDetail;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ConfirmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $searchValue = $request->input('search');

        $columns = [
            array('title' => 'Procurement No', 'field' => 'procurement_no'),
            array('title' => 'User Procurement', 'field' => 'proc_name'),
            array('title' => 'Remarks', 'field' => 'remark'),
            array('title' => 'File', 'field' => 'file'),
            array('title' => 'Status', 'field' => 'status_name', 'type' => 'html'),
            array('title' => 'Created At', 'field' => 'created_at_date'),
        ];

        $config = [
            //Title Required
            'title' => 'Confirm Incoming Items',
            /*
             * Route Can Be Null
             */
            //Route For Button Add
            'route-add' => 'admin.warehouseIn.confirm.create',
            //Route For Button View
            'route-view' => 'admin.warehouseIn.confirm.show',
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
     * @return Response
     */
    public function create()
    {
        $config = [
            'vue-component' => '<add-warehouse-confirm/>',
        ];

        return view('layouts.vue-view', compact('config'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $data = Confirm::findOrFail($id);
        $detail = ConfirmDetail::where('warehouse_confirm_id', $id)->get();

        $columns = [
            array('title' => 'Procurement No', 'field' => 'procurement_no'),
            array('title' => 'User Procurement', 'field' => 'proc_name'),
            array('title' => 'Status', 'field' => 'status_name'),
            array('title' => 'Remarks', 'field' => 'remarks'),
            array('title' => 'File', 'field' => 'file'),
        ];

        $detailColumns = [
            array('title' => 'Item', 'field' => 'item_name'),
            array('title' => 'Qty', 'field' => 'qty_proc'),
            array('title' => 'Uom', 'field' => 'uom_name'),
            array('title' => 'Bruto (Berat Kotor)', 'field' => 'bruto'),
            array('title' => 'Netto (Berat Bersih)', 'field' => 'netto'),
        ];

        $config = [
            //Title Required
            'title' => 'Detail',

            //Route For Button Back
            'back-button' => 'admin.warehouseIn.confirm.index',
        ];

        return view('admin.crud.detail', compact('data', 'detail', 'config', 'columns', 'detailColumns'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
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
     * @return Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     */
    public function destroy($id)
    {
    }
}
