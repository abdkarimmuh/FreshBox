<?php

namespace App\Http\Controllers\WarehouseIn;

use App\Http\Controllers\Controller;
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
            array('title' => 'Procurement No', 'field' => 'procurement_no'),
            array('title' => 'User Procurement', 'field' => 'proc_name'),
            array('title' => 'Remarks', 'field' => 'remarks'),
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
