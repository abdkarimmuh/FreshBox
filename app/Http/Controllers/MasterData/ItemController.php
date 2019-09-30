<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MasterData\Category;
use App\Model\MasterData\Item;
use App\Model\MasterData\Origin;
use App\Model\MasterData\Uom;
use Illuminate\Support\Facades\DB;

class ItemController extends Controller
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
            array('title' => 'SKUID', 'field' => 'skuid'),
            array('title' => 'Item Name', 'field' => 'name_item'),
            array('title' => 'Item Latin Name', 'field' => 'name_item_latin'),
            array('title' => 'Category', 'field' => 'category_name'),
            array('title' => 'Trf Item', 'field' => 'is_trf_item'),
            array('title' => 'UOM', 'field' => 'uom_name'),
            array('title' => 'Tax', 'field' => 'tax_percentage'),
            array('title' => 'Origin Code', 'field' => 'origin_code'),
            array('title' => 'Description', 'field' => 'description'),
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
            array('title' => 'Modified By', 'field' => 'updated_by_name'),
            array('title' => 'Modified At', 'field' => 'updated_at'),
        ];

        $config = [
            //Title Required
            'title' => 'Item',
            /**
             * Route Can Be Null
             */
            //Route For Button Add
            'route-add' => 'admin.master_data.item.create',
            //Route For Button Edit
            'route-edit' => 'admin.master_data.item.edit',
            //Route For Button Search
            'route-search' => 'admin.master_data.item.index',
        ];

        $query = Item::dataTableQuery($searchValue);
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
        $category = Category::all();
        $origin = Origin::all();
        $uom = Uom::all();

        $is_trf_item = [
            array('id' => 1, 'label' => 'Yes', 'value' => 'Y'),
            array('id' => 2, 'label' => 'No', 'value' => 'N'),
        ];

        $forms = [
            array('type' => 'number', 'label' => 'SKUID', 'name' => 'skuid', 'place_holder' => 'SKUID', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Category', 'name' => 'category', 'variable' => 'category', 'option_value'=> 'id', 'option_text' => 'name', 'mandatory' => true),
            array('type' => 'text', 'label' => 'Item Name', 'name' => 'name_item', 'place_holder' => 'Item Name', 'mandatory' => true),
            array('type' => 'text', 'label' => 'Item Name Latin', 'name' => 'name_item_latin', 'place_holder' => 'Item Name Latin', 'mandatory' => false),
            array('type' => 'radio', 'label' => 'Is Transfer', 'name' => 'is_trf_item', 'variable' => 'is_trf_item', 'option_value'=> 'value', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Origin', 'name' => 'origin', 'variable' => 'origin', 'option_value'=> 'id', 'option_text' => 'description', 'mandatory' => true),
            array('type' => 'percentage', 'label' => 'Tax', 'name' => 'tax', 'place_holder' => 'Tax', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Uom', 'name' => 'uom', 'variable' => 'uom', 'option_value'=> 'id', 'option_text' => 'name', 'mandatory' => true),
            array('type' => 'textarea', 'label' => 'Description', 'name' => 'description', 'place_holder' => 'Description', 'mandatory' => false),
        ];
        $config = [
            //Form Title
            'title' => 'Create Item',
            //Form Action Using Route Name
            'action' => 'admin.master_data.item.store',
            //Form Method
            'method' => 'POST',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.item.index'
        ];

        return view('admin.crud.create_or_edit', compact('forms', 'config', 'category', 'is_trf_item', 'origin', 'uom'));
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
            'skuid' => 'required',
            'category' => 'required',
            'name_item' => 'required',
            'is_trf_item' => 'required',
            'origin' => 'required',
            'tax' => 'required',
            'uom' => 'required',
        ]);

        DB::select('call insert_item(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($request->skuid, $request->name_item, $request->name_item_latin, $request->description, $request->is_trf_item, $request->category, $request->uom, $request->origin, $request->tax, auth()->user()->id));
        return redirect('admin/master_data/item');
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
        $category = Category::all();
        $origin = Origin::all();
        $uom = Uom::all();

        $is_trf_item = [
            array('id' => 1, 'label' => 'Yes', 'value' => 'Y'),
            array('id' => 2, 'label' => 'No', 'value' => 'N'),
        ];

        $forms = [
            array('type' => 'number', 'label' => 'SKUID', 'name' => 'skuid', 'place_holder' => 'SKUID', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Category', 'name' => 'category', 'variable' => 'category', 'option_value'=> 'id', 'option_text' => 'name', 'mandatory' => true),
            array('type' => 'text', 'label' => 'Item Name', 'name' => 'name_item', 'place_holder' => 'Item Name', 'mandatory' => true),
            array('type' => 'text', 'label' => 'Item Name Latin', 'name' => 'name_item_latin', 'place_holder' => 'Item Name Latin', 'mandatory' => false),
            array('type' => 'radio', 'label' => 'Is Transfer', 'name' => 'is_trf_item', 'variable' => 'is_trf_item', 'option_value'=> 'value', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Origin', 'name' => 'origin', 'variable' => 'origin', 'option_value'=> 'id', 'option_text' => 'description', 'mandatory' => true),
            array('type' => 'percentage', 'label' => 'Tax', 'name' => 'tax', 'place_holder' => 'Tax', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Uom', 'name' => 'uom', 'variable' => 'uom', 'option_value'=> 'id', 'option_text' => 'name', 'mandatory' => true),
            array('type' => 'textarea', 'label' => 'Description', 'name' => 'description', 'place_holder' => 'Description', 'mandatory' => false),
        ];
        $config = [
            //Form Title
            'title' => 'Update Item',
            //Form Action Using Route Name
            'action' => 'admin.master_data.item.update',
            //Form Method
            'method' => 'PATCH',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.item.index'
        ];

        $data = Item::find($id);

        return view('admin.crud.create_or_edit', compact('forms', 'config', 'category', 'is_trf_item', 'origin', 'uom', 'data'));
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
            'skuid' => 'required',
            'category' => 'required',
            'name_item' => 'required',
            'is_trf_item' => 'required',
            'origin' => 'required',
            'tax' => 'required',
            'uom' => 'required',
        ]);

        DB::select('call update_item(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($request->id, $request->skuid, $request->name_item, $request->name_item_latin, $request->description, $request->is_trf_item, $request->category, $request->uom, $request->origin, $request->tax, auth()->user()->id));
        return redirect('admin/master_data/item');
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
