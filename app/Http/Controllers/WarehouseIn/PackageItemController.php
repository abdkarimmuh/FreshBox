<?php

namespace App\Http\Controllers\WarehouseIn;

use App\Http\Controllers\Controller;
use App\Model\Marketing\SalesOrderDetail;
use Illuminate\Http\Request;

class PackageItemController extends Controller
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
            array('title' => 'Item Name', 'field' => 'item_name'),
            array('title' => 'Sales Order No', 'field' => 'sales_order_no'),
            array('title' => 'Status', 'field' => 'status_name', 'type' => 'html'),
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
        ];

        $config = [
            //Title Required
            'title' => 'Package Items',
            /*
             * Route Can Be Null
             */
            //Route For Button View
            // 'route-view' => 'admin.warehouseIn.packageItem.show',
            //Route For Button Search
            'route-search' => 'admin.warehouseIn.packageItem.index',
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
        $config = [
            'vue-component' => '<add-warehouse-package-item/>',
        ];

        return view('layouts.vue-view', compact('config'));
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
