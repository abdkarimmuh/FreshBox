<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MasterData\Warehouse;
use Carbon\Carbon;

class WarehouseController extends Controller
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
            array('title' => 'Address', 'field' => 'address'),
            array('title' => 'Created At', 'field' => 'created_at_name'),
            array('title' => 'Modified At', 'field' => 'updated_at_name'),
        ];

        $config = [
            //Title Required
            'title' => 'Warehouse',
            /*
             * Route Can Be Null
             */
            //Route For Button Add
            'route-add' => 'admin.master_data.warehouse.create',
            //Route For Button Edit
            'route-edit' => 'admin.master_data.warehouse.edit',
            //Route For Button Search
            'route-search' => 'admin.master_data.warehouse.index',
        ];

        $query = Warehouse::dataTableQuery($searchValue);
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
            array('type' => 'text', 'label' => 'Name', 'name' => 'name', 'place_holder' => 'Name', 'mandatory' => true),
            array('type' => 'textarea', 'label' => 'Address', 'name' => 'address', 'place_holder' => 'Address', 'mandatory' => true),
        ];

        $config = [
            //Form Title
            'title' => 'Create Warehouse',
            //Form Action Using Route Name
            'action' => 'admin.master_data.warehouse.store',
            //Form Method
            'method' => 'POST',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.warehouse.index',
        ];

        return view('admin.crud.create_or_edit', compact('forms', 'config'));
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
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        Warehouse::create([
            'name' => $request->name,
            'address' => $request->address,
            'created_at' => Carbon::now(),
        ]);

        return redirect('admin/master_data/warehouse');
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
        //Form Generator
        $forms = [
            array('type' => 'text', 'label' => 'Name', 'name' => 'name', 'place_holder' => 'Name', 'mandatory' => true),
            array('type' => 'textarea', 'label' => 'Address', 'name' => 'address', 'place_holder' => 'Address', 'mandatory' => true),
        ];

        $config = [
            //Form Title
            'title' => 'Update Warehouse',
            //Form Action Using Route Name
            'action' => 'admin.master_data.warehouse.update',
            //Form Method
            'method' => 'PATCH',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.warehouse.index',
        ];

        $data = Warehouse::find($id);

        return view('admin.crud.create_or_edit', compact('forms', 'config', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'address' => 'required',
        ]);

        $data = Warehouse::find($request->id);
        $data->name = $request->name;
        $data->address = $request->address;
        $data->updated_at = Carbon::now();
        $data->save();

        return redirect('admin/master_data/warehouse');
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
