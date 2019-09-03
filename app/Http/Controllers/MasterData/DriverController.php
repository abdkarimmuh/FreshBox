<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MasterData\Driver;
use Illuminate\Support\Facades\DB;

class DriverController extends Controller
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
            array('title' => 'Nama', 'field' => 'name'),
            array('title' => 'Phone Number', 'field' => 'phone_number'),
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
            array('title' => 'Modified By', 'field' => 'updated_by_name'),
            array('title' => 'Modified At', 'field' => 'updated_at'),
        ];

        $config = [
            //Title Required
            'title' => 'Driver',
            /**
             * Route Can Be Null
             */
            //Route For Button Add
            'route-add' => 'admin.master_data.driver.create',
            //Route For Button Edit
            'route-edit' => 'admin.master_data.driver.edit',
            //Route For Button Search
            'route-search' => 'admin.master_data.driver.index',
        ];

        $query = Driver::dataTableQuery($searchValue);
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
        //Form Generator
        $forms = [
            array('type' => 'text', 'label' => 'Driver Name', 'name' => 'name', 'place_holder' => 'Driver Name', 'mandatory' => true),
            array('type' => 'number', 'label' => 'Phone Number', 'name' => 'phone_number', 'place_holder' => 'Phone Number', 'mandatory' => true),
        ];
        $config = [
            //Form Title
            'title' => 'Create Driver',
            //Form Action Using Route Name
            'action' => 'admin.master_data.driver.store',
            //Form Method
            'method' => 'POST',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.driver.index'
        ];

        return view('admin.crud.create_or_edit', compact('forms', 'config'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::select('call insert_driver(?, ?, ?)', array($request->name, $request->phone_number, auth()->user()->id));
        return redirect('admin/master_data/driver');
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
        //Form Generator
        $forms = [
            array('type' => 'text', 'label' => 'Driver Name', 'name' => 'name', 'place_holder' => 'Driver Name', 'mandatory' => true),
            array('type' => 'text', 'label' => 'Phone Number', 'name' => 'phone_number', 'place_holder' => 'Phone Number', 'mandatory' => true)
        ];
        $config = [
            //Form Title
            'title' => 'Update Driver',
            //Form Action Using Route Name
            'action' => 'admin.master_data.driver.update',
            //Form Method
            'method' => 'PATCH',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.driver.index'
        ];

        $data = Driver::find($id);

        return view('admin.crud.create_or_edit', compact('forms', 'config', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        DB::select('call update_driver(?, ?, ?, ?)', array($request->id, $request->name, $request->phone_number, auth()->user()->id));
        return redirect('admin/master_data/driver');
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
