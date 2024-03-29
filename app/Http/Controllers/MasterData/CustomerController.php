<?php

namespace App\Http\Controllers\MasterData;

use App\Model\MasterData\CustomerGroup;
use App\Model\MasterData\CustomerType;
use App\Model\MasterData\Province;
use App\Model\MasterData\Residence;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MasterData\Customer;
use Illuminate\Support\Facades\DB;

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
            'route-edit' => 'admin.master_data.customer.edit',
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
        //Form Generator
        $customerType = CustomerType::all();
        $customerGroup = CustomerGroup::all();
        $residence = Residence::all();
        $province = Province::all();

        $forms = [
            array('type' => 'select_option', 'label' => 'Customer Type', 'name' => 'customerType', 'variable' => 'customerType', 'option_value'=> 'id', 'option_text' => 'name','mandatory' => true),
            array('type' => 'select_option', 'label' => 'Customer Group', 'name' => 'customerGroup', 'variable' => 'customerGroup','option_value'=> 'id', 'option_text' => 'name', 'mandatory' => true),
            array('type' => 'text', 'label' => 'Customer Code', 'name' => 'customer_code', 'place_holder' => 'Customer Code', 'mandatory' => true),
            array('type' => 'text', 'label' => 'Customer Name', 'name' => 'name', 'place_holder' => 'Customer Name', 'mandatory' => true),
            array('type' => 'text', 'label' => 'PIC Name', 'name' => 'pic_customer', 'place_holder' => 'PIC Name', 'mandatory' => true),
            array('type' => 'number', 'label' => 'PIC Contact', 'name' => 'tlp_pic', 'place_holder' => 'PIC Contact', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Province', 'name' => 'province', 'variable' => 'province', 'option_value'=> 'id', 'option_text' => 'name','mandatory' => true),
            array('type' => 'select_option', 'label' => 'Residence', 'name' => 'residence', 'variable' => 'residence', 'option_value'=> 'id', 'option_text' => 'name','mandatory' => true),
            array('type' => 'number', 'label' => 'Kode Pos', 'name' => 'kodepos', 'place_holder' => 'Kode Pos', 'mandatory' => false),
            array('type' => 'textarea', 'label' => 'Alamat', 'name' => 'address', 'place_holder' => 'Alamat', 'mandatory' => true),
        ];
        $config = [
            //Form Title
            'title' => 'Create Customer',
            //Form Action Using Route Name
            'action' => 'admin.master_data.customer.store',
            //Form Method
            'method' => 'POST',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.customer.index'
        ];

        return view('admin.crud.create_or_edit', compact('forms', 'config', 'customerType', 'customerGroup', 'province', 'residence'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'customer_code' => 'required',
            'customerType' => 'required',
            'customerGroup' => 'required',
            'name' => 'required',
            'pic_customer' => 'required',
            'tlp_pic' => 'required',
            'province' => 'required',
            'residence' => 'required',
            'address' => 'required',
        ]);

        DB::select('call insert_customer(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($request->customer_code, $request->customerType, $request->customerGroup, $request->name, $request->pic_customer, $request->tlp_pic, $request->address, $request->province, $request->residence, $request->kodepos, null, null, auth()->user()->id));
        return redirect('admin/master_data/customer');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //Form Generator
        $customerType = CustomerType::all();
        $customerGroup = CustomerGroup::all();
        $residence = Residence::all();
        $province = Province::all();

        $forms = [
            array('type' => 'select_option', 'label' => 'Customer Type', 'name' => 'customerType', 'variable' => 'customerType', 'option_value'=> 'id', 'option_text' => 'name','mandatory' => true),
            array('type' => 'select_option', 'label' => 'Customer Group', 'name' => 'customerGroup', 'variable' => 'customerGroup', 'option_value'=> 'id', 'option_text' => 'name', 'mandatory' => true),
            array('type' => 'text', 'label' => 'Customer Code', 'name' => 'customer_code', 'place_holder' => 'Customer Code', 'mandatory' => true),
            array('type' => 'text', 'label' => 'Customer Name', 'name' => 'name', 'place_holder' => 'Customer Name', 'mandatory' => true),
            array('type' => 'text', 'label' => 'PIC Name', 'name' => 'pic_customer', 'place_holder' => 'PIC Name', 'mandatory' => true),
            array('type' => 'number', 'label' => 'PIC Contact', 'name' => 'tlp_pic', 'place_holder' => 'PIC Contact', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Province', 'name' => 'province', 'variable' => 'province', 'option_value'=> 'id', 'option_text' => 'name','mandatory' => true),
            array('type' => 'select_option', 'label' => 'Residence', 'name' => 'residence', 'variable' => 'residence', 'option_value'=> 'id', 'option_text' => 'name','mandatory' => true),
            array('type' => 'number', 'label' => 'Kode Pos', 'name' => 'kodepos', 'place_holder' => 'Kode Pos', 'mandatory' => false),
            array('type' => 'textarea', 'label' => 'Alamat', 'name' => 'address', 'place_holder' => 'Alamat', 'mandatory' => true),
        ];
        $config = [
            //Form Title
            'title' => 'Update Customer',
            //Form Action Using Route Name
            'action' => 'admin.master_data.customer.update',
            //Form Method
            'method' => 'PATCH',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.customer.index'
        ];

        $data = Customer::find($id);


        return view('admin.crud.create_or_edit', compact('forms', 'config', 'customerType', 'customerGroup', 'province', 'residence', 'data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $request->validate([
            'customer_code' => 'required',
            'customerType' => 'required',
            'customerGroup' => 'required',
            'name' => 'required',
            'pic_customer' => 'required',
            'tlp_pic' => 'required',
            'province' => 'required',
            'residence' => 'required',
        ]);

        DB::select('call update_customer(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)', array($request->id ,$request->customer_code, $request->customerType, $request->customerGroup, $request->name, $request->pic_customer, $request->tlp_pic, $request->address, $request->province, $request->residence, $request->kodepos, null, null, auth()->user()->id));
        return redirect('admin/master_data/customer');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
