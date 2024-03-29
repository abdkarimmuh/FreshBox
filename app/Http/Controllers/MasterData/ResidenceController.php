<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MasterData\Province;
use App\Model\MasterData\Residence;
use Illuminate\Support\Facades\DB;

class ResidenceController extends Controller
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
            array('title' => 'Province', 'field' => 'province_name'),
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
            array('title' => 'Modified By', 'field' => 'updated_by_name'),
            array('title' => 'Modified At', 'field' => 'updated_at'),
        ];

        $config = [
            //Title Required
            'title' => 'Residence',
            /**
             * Route Can Be Null
             */
            //Route For Button Add
            'route-add' => 'admin.master_data.residence.create',
            //Route For Button Edit
            'route-edit' => 'admin.master_data.residence.edit',
            //Route For Button Search
            'route-search' => 'admin.master_data.residence.index',
        ];

        $query = Residence::dataTableQuery($searchValue);
        $data = $query->paginate(10);

        return view('admin.crud.index', compact('columns', 'data', 'config'));
        // return $data;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $province = Province::all();

        //Form Generator
        $forms = [
            array('type' => 'text', 'label' => 'Residence', 'name' => 'name', 'place_holder' => 'Province', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Province', 'name' => 'province', 'variable' => 'province', 'option_value'=> 'id', 'option_text' => 'name','mandatory' => true),
        ];
        $config = [
            //Form Title
            'title' => 'Create Residence',
            //Form Action Using Route Name
            'action' => 'admin.master_data.residence.store',
            //Form Method
            'method' => 'POST',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.residence.index'
        ];

        return view('admin.crud.create_or_edit', compact('forms', 'config', 'province'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'province' => 'required',
        ]);

        DB::select('call insert_residence(?, ?, ?)', array($request->name, $request->province, auth()->user()->id));
        return redirect('admin/master_data/residence');
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
            array('type' => 'text', 'label' => 'Province', 'name' => 'name', 'place_holder' => 'Province', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Province', 'name' => 'province', 'variable' => 'province', 'option_value'=> 'id', 'option_text' => 'name','mandatory' => true),
        ];
        $config = [
            //Form Title
            'title' => 'Update Residence',
            //Form Action Using Route Name
            'action' => 'admin.master_data.residence.update',
            //Form Method
            'method' => 'PATCH',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.residence.index'
        ];

        $province = Province::all();
        $data = Residence::find($id);

        return view('admin.crud.create_or_edit', compact('forms', 'config', 'data', 'province'));
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
        $request->validate([
            'name' => 'required',
            'province' => 'required',
        ]);

        DB::select('call update_residence(?, ?, ?, ?)', array($request->id, $request->name, $request->province, auth()->user()->id));
        return redirect('admin/master_data/residence');
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
