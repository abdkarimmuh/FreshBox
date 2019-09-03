<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MasterData\Category;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
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
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
            array('title' => 'Modified By', 'field' => 'updated_by_name'),
            array('title' => 'Modified At', 'field' => 'updated_at'),
        ];

        $config = [
            //Title Required
            'title' => 'Category',
            /**
             * Route Can Be Null
             */
            //Route For Button Add
            'route-add' => 'admin.master_data.category.create',
            //Route For Button Edit
            'route-edit' => 'admin.master_data.category.edit',
            //Route For Button Search
            'route-search' => 'admin.master_data.category.index',
        ];

        $query = Category::dataTableQuery($searchValue);
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
            array('type' => 'text', 'label' => 'Category Name', 'name' => 'name', 'place_holder' => 'Category Name', 'mandatory' => true)
        ];
        $config = [
            //Form Title
            'title' => 'Create Category',
            //Form Action Using Route Name
            'action' => 'admin.master_data.category.store',
            //Form Method
            'method' => 'POST',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.category.index'
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
        DB::select('call insert_category(?, ?)', array($request->name, auth()->user()->id));
        return redirect('admin/master_data/category');
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
            array('type' => 'text', 'label' => 'Category Name', 'name' => 'name', 'place_holder' => 'Category Name', 'mandatory' => true)
        ];
        $config = [
            //Form Title
            'title' => 'Update Category',
            //Form Action Using Route Name
            'action' => 'admin.master_data.category.update',
            //Form Method
            'method' => 'PATCH',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.category.index'
        ];

        $data = Category::find($id);

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
        DB::select('call update_category(?, ?, ?)', array($request->id, $request->name, auth()->user()->id));
        return redirect('admin/master_data/category');
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
