<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Model\Marketing\SalesOrderDetail;
use Illuminate\Http\Request;

class ItemProcurementController extends Controller
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
            // array('title' => 'Nama', 'field' => 'proc_name'),
            array('title' => 'Sales Order No', 'field' => 'sales_order_no'),
            array('title' => 'Nama Barang', 'field' => 'item_name'),
            array('title' => 'Qty', 'field' => 'qty'),
            array('title' => 'UOM', 'field' => 'uom_name'),
            array('title' => 'Area', 'field' => 'origin_code'),
            array('title' => 'Status', 'field' => 'status_name', 'type' => 'html'),
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
            array('title' => 'Modified By', 'field' => 'updated_by_name'),
            array('title' => 'Modified At', 'field' => 'updated_at'),
        ];

        $config = [
            //Title Required
            'title' => 'Item Procurement',
            /*
             * Route Can Be Null
             */
            //Route For Button Add
            // 'route-add' => 'admin.procurement.item_procurement.create',
            //Route For Button Edit
            // 'route-edit' => 'admin.procurement.item_procurement.edit',
            //Route For Button Search
            'route-search' => 'admin.procurement.item_procurement.index',
        ];

        $query = SalesOrderDetail::dataTableQuery($searchValue);
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
}
