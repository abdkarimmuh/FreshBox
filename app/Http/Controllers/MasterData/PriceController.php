<?php

namespace App\Http\Controllers\MasterData;

use App\Model\MasterData\Customer;
use App\Model\MasterData\Item;
use App\Model\MasterData\Uom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MasterData\Price;
use App\Model\MasterData\PriceGroupCust;
use Carbon\Carbon;

class PriceController extends Controller
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
            array('title' => 'Item Name', 'field' => 'item_name'),
            array('title' => 'UOM', 'field' => 'uom_name'),
            array('title' => 'Customer Group Name', 'field' => 'customer_group_name'),
            array('title' => 'Amount', 'field' => 'amount'),
            array('title' => 'Tax', 'field' => 'tax_value'),
            array('title' => 'Start Periode', 'field' => 'start_periode'),
            array('title' => 'End Periode', 'field' => 'end_periode'),
            array('title' => 'Remarks', 'field' => 'remarks'),
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
        ];

        $config = [
            //Title Required
            'title' => 'Price',
            /*
             * Route Can Be Null
             */
            //Route For Button Add
            'route-add' => 'admin.master_data.price.create',
            //Route For Button Edit
//            'route-edit' => 'testing.edit',
            //Route For Button Search
            'route-search' => 'admin.master_data.price.index',
            //Route Upload
            'route-upload' => 'admin/import/price',
        ];

        $month = Carbon::now()->subMonth(2)->format('y-m-d');
        $now = Carbon::now()->format('y-m-d');

        $query = PriceGroupCust::where('end_periode', '>', $now)->where('start_periode', '>', $month)->dataTableQuery($searchValue);
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
        $items = Item::all();
        $uoms = Uom::all();
        $customers = Customer::all();

        $forms = [
            array('type' => 'select_option', 'label' => 'Customer', 'name' => 'customer', 'variable' => 'customers', 'option_value' => 'id', 'option_text' => 'name', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'SKUID', 'name' => 'skuid', 'variable' => 'items', 'option_value' => 'skuid', 'option_text' => 'skuid_item_name', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Uom', 'name' => 'uom', 'variable' => 'uoms', 'option_value' => 'id', 'option_text' => 'name', 'mandatory' => true),

            array('type' => 'text', 'label' => 'Amount Basic', 'name' => 'amount_basic', 'place_holder' => 'Amount Basic', 'mandatory' => true),
            array('type' => 'text', 'label' => 'Amount Discount', 'name' => 'amount_discount', 'place_holder' => 'Amount Discount', 'mandatory' => true),
            array('type' => 'percentage', 'label' => 'Tax', 'name' => 'tax_value', 'place_holder' => 'Tax', 'mandatory' => false),
            array('type' => 'datepicker', 'label' => 'Start Period', 'name' => 'start_periode', 'place_holder' => 'Start Period', 'mandatory' => true),
            array('type' => 'datepicker', 'label' => 'End Period', 'name' => 'end_periode', 'place_holder' => 'End Period', 'mandatory' => true),
            array('type' => 'textarea', 'label' => 'Remarks', 'name' => 'remarks', 'place_holder' => 'Remarks', 'mandatory' => false),
        ];
        $config = [
            //Form Title
            'title' => 'Create Price',
            //Form Action Using Route Name
            'action' => 'admin.master_data.price.store',
            //Form Method
            'method' => 'POST',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.price.index',
        ];

        return view('admin.crud.create_or_edit', compact('forms', 'config', 'items', 'uoms', 'customers'));
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
            'customer' => 'required',
            'skuid' => 'required',
            'uom' => 'required',
            'amount_basic' => 'required',
            'start_periode' => 'required',
            'end_periode' => 'required',
        ]);
        $amount = $request->amount_basic - $request->amount_discount;
        $price = [
            'skuid' => $request->skuid,
            'uom_id' => $request->uom,
            'customer_id' => $request->customer,
            'amount_basic' => $request->amount_basic,
            'amount_discount' => $request->amount_discount,
            'amount' => $amount,
            'tax_value' => $request->tax_value,
            'start_periode' => $request->start_periode,
            'end_periode' => $request->end_periode,
            'created_by' => auth()->user()->id,
        ];
        Price::create($price);

        return redirect()->route('admin.master_data.price.index');
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
