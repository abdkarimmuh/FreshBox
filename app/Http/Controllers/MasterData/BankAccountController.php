<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MasterData\Bank;
use App\Model\MasterData\BankAccout;
use Carbon\Carbon;

class BankAccountController extends Controller
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
            array('title' => 'Bank Name', 'field' => 'bank_name'),
            array('title' => 'Bank Account', 'field' => 'bank_account'),
            array('title' => 'Created At', 'field' => 'created_at_name'),
            array('title' => 'Modified At', 'field' => 'updated_at_name')
        ];

        $config = [
            //Title Required
            'title' => 'Bank Account',
            /*
             * Route Can Be Null
             */
            //Route For Button Add
            'route-add' => 'admin.master_data.bank_account.create',
            //Route For Button Edit
            'route-edit' => 'admin.master_data.bank_account.edit',
            //Route For Button Search
            'route-search' => 'admin.master_data.bank_account.index',
        ];

        $query = BankAccout::dataTableQuery($searchValue);
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
        $bank = Bank::all();

        //Form Generator
        $forms = [
            array('type' => 'text', 'label' => 'Name', 'name' => 'name', 'place_holder' => 'Name', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Bank Name', 'name' => 'bank', 'variable' => 'bank', 'option_value' => 'id', 'option_text' => 'name', 'mandatory' => true),
            array('type' => 'number', 'label' => 'No Rekening', 'name' => 'bank_account', 'place_holder' => 'No Rekening', 'mandatory' => true),
        ];

        $config = [
            //Form Title
            'title' => 'Create Bank Account',
            //Form Action Using Route Name
            'action' => 'admin.master_data.bank_account.store',
            //Form Method
            'method' => 'POST',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.bank_account.index',
        ];

        return view('admin.crud.create_or_edit', compact('forms', 'config', 'bank'));
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
            'bank_account' => 'required',
            'bank' => 'required',
        ]);

        BankAccout::create([
            'name' => $request->name,
            'bank_account' => $request->bank_account,
            'bank_id' => $request->bank,
            'created_at' => Carbon::now(),
        ]);

        return redirect('admin/master_data/bank_account');
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
        $bank = Bank::all();

        $forms = [
            array('type' => 'text', 'label' => 'Name', 'name' => 'name', 'place_holder' => 'Name', 'mandatory' => true),
            array('type' => 'number', 'label' => 'No Rekening', 'name' => 'bank_account', 'place_holder' => 'No Rekening', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Bank Name', 'name' => 'bank', 'variable' => 'bank', 'option_value' => 'id', 'option_text' => 'name', 'mandatory' => true),
        ];

        $config = [
            //Form Title
            'title' => 'Update Bank Account',
            //Form Action Using Route Name
            'action' => 'admin.master_data.bank_account.update',
            //Form Method
            'method' => 'PATCH',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.bank_account.index',
        ];

        $data = BankAccout::find($id);

        return view('admin.crud.create_or_edit', compact('forms', 'config', 'data', 'bank'));
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
            'bank_account' => 'required',
            'bank' => 'required',
        ]);

        $data = BankAccout::find($request->id);
        $data->name = $request->name;
        $data->bank_account = $request->bank_account;
        $data->bank_id = $request->bank;
        $data->updated_at = Carbon::now();
        $data->save();

        return redirect('admin/master_data/bank_account');
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
