<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MasterData\Bank;
use App\Model\MasterData\Category;
use App\Model\MasterData\Vendor;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
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
            array('title' => 'Category', 'field' => 'category_name'),
            array('title' => 'PIC Vendor', 'field' => 'pic_vendor'),
            array('title' => 'PIC Contact', 'field' => 'tlp_pic'),
            array('title' => 'No Rekening', 'field' => 'bank_account'),
            array('title' => 'Bank Name', 'field' => 'bank_name'),
            array('title' => 'Remarks', 'field' => 'remarks'),
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
            array('title' => 'Modified By', 'field' => 'updated_by_name'),
            array('title' => 'Modified At', 'field' => 'updated_at'),
        ];

        $config = [
            //Title Required
            'title' => 'Vendor',
            /*
             * Route Can Be Null
             */
            //Route For Button Add
            'route-add' => 'admin.master_data.vendor.create',
            //Route For Button Edit
            'route-edit' => 'admin.master_data.vendor.edit',
            //Route For Button Search
            'route-search' => 'admin.master_data.vendor.index',
        ];

        $query = Vendor::dataTableQuery($searchValue);
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
        $bank = Bank::all();

        $forms = [
            array('type' => 'text', 'label' => 'Nama', 'name' => 'name', 'place_holder' => 'Nama', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Category', 'name' => 'category', 'variable' => 'category', 'option_value' => 'id', 'option_text' => 'name', 'mandatory' => true),
            array('type' => 'text', 'label' => 'PIC Vendor', 'name' => 'pic_vendor', 'place_holder' => 'PIC Vendor', 'mandatory' => true),
            array('type' => 'number', 'label' => 'PIC Contact', 'name' => 'tlp_pic', 'place_holder' => 'PIC Contact', 'mandatory' => true),
            array('type' => 'number', 'label' => 'No Rekening', 'name' => 'bank_account', 'place_holder' => 'No Rekening', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Bank Name', 'name' => 'bank', 'variable' => 'bank', 'option_value' => 'id', 'option_text' => 'name', 'mandatory' => true),
            array('type' => 'textarea', 'label' => 'Remarks', 'name' => 'remarks', 'place_holder' => 'Remarks', 'mandatory' => false),
        ];

        $config = [
            //Form Title
            'title' => 'Create Vendor',
            //Form Action Using Route Name
            'action' => 'admin.master_data.vendor.store',
            //Form Method
            'method' => 'POST',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.vendor.index',
        ];

        return view('admin.crud.create_or_edit', compact('forms', 'config', 'category', 'bank'));
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
            'category' => 'required',
            'pic_vendor' => 'required',
            'tlp_pic' => 'required',
            'bank_account' => 'required',
            'bank' => 'required',
        ]);

        DB::select('call insert_vendor(?, ?, ?, ?, ?, ?, ?, ?, ?)', array($request->name, $request->category, $request->pic_vendor, $request->tlp_pic, $request->bank_account, $request->bank, 2, $request->remarks, auth()->user()->id));

        return redirect('admin/master_data/vendor');
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
        $category = Category::all();
        $bank = Bank::all();

        $forms = [
            array('type' => 'text', 'label' => 'Nama', 'name' => 'name', 'place_holder' => 'Nama', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Category', 'name' => 'category', 'variable' => 'category', 'option_value' => 'id', 'option_text' => 'name', 'mandatory' => true),
            array('type' => 'text', 'label' => 'PIC Vendor', 'name' => 'pic_vendor', 'place_holder' => 'PIC Vendor', 'mandatory' => true),
            array('type' => 'number', 'label' => 'PIC Contact', 'name' => 'tlp_pic', 'place_holder' => 'PIC Contact', 'mandatory' => true),
            array('type' => 'number', 'label' => 'No Rekening', 'name' => 'bank_account', 'place_holder' => 'No Rekening', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Bank Name', 'name' => 'bank', 'variable' => 'bank', 'option_value' => 'id', 'option_text' => 'name', 'mandatory' => true),
            array('type' => 'textarea', 'label' => 'Remarks', 'name' => 'remarks', 'place_holder' => 'Remarks', 'mandatory' => false),
        ];

        $config = [
            //Form Title
            'title' => 'Update Vendor',
            //Form Action Using Route Name
            'action' => 'admin.master_data.vendor.update',
            //Form Method
            'method' => 'PATCH',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.vendor.index',
        ];

        $data = Vendor::find($id);

        return view('admin.crud.create_or_edit', compact('forms', 'config', 'category', 'bank', 'data'));
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
            'category' => 'required',
            'pic_vendor' => 'required',
            'tlp_pic' => 'required',
            'bank_account' => 'required',
            'bank' => 'required',
        ]);

        DB::select('call update_vendor(?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($request->id, $request->name, $request->category, $request->pic_vendor, $request->tlp_pic, $request->bank_account, $request->bank, 2, $request->remarks, auth()->user()->id));

        return redirect('admin/master_data/vendor');
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
