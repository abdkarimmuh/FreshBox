<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MasterData\Customer;

class CustomerController extends Controller
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
            array('title' => 'Customer Code', 'field' => 'customer_code'),
            array('title' => 'Customer Type', 'field' => 'customer_type_name'),
            array('title' => 'Customer Group', 'field' => 'customer_group_name'),
            array('title' => 'Customer Name', 'field' => 'name'),
            array('title' => 'PIC Name', 'field' => 'pic_customer'),
            array('title' => 'PIC Contact', 'field' => 'tlp_pic'),
            array('title' => 'Alamat', 'field' => 'address'),
            array('title' => 'Provinsi', 'field' => 'province_name'),
            array('title' => 'Kota', 'field' => 'residence_name'),
            array('title' => 'Kode Pos', 'field' => 'kodepos'),
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
            array('title' => 'Modified By', 'field' => 'updated_by_name'),
            array('title' => 'Modified At', 'field' => 'updated_at'),
        ];

        $config = [
            //Title Required
            'title' => 'Customer',
            /**
             * Route Can Be Null
             */
            //Route For Button Add
            'route-add' => 'admin.master_data.customer.create',
            //Route For Button Edit
            'route-edit' => 'testing.edit',
            //Route For Button Search
            'route-search' => 'admin.master_data.customer.index',
        ];

        $query = Customer::dataTableQuery($searchValue);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
