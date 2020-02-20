<?php

namespace App\Http\Controllers\MasterData;

use App\Model\MasterData\Item;
use App\Model\MasterData\Uom;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Model\MasterData\CustomerGroup;
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
            array('title' => 'Start Periodee', 'field' => 'start_periode'),
            array('title' => 'End Periodee', 'field' => 'end_periode'),
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
        $item = Item::all();
        $uom = Uom::all();
        $customerGroup = CustomerGroup::all();

        $forms = [
            array('type' => 'select_option', 'label' => 'Customer', 'name' => 'customerGroup', 'variable' => 'customerGroup', 'option_value' => 'id', 'option_text' => 'name', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'SKUID', 'name' => 'skuid', 'variable' => 'item', 'option_value' => 'skuid', 'option_text' => 'skuid_item_name', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Uom', 'name' => 'uom', 'variable' => 'uom', 'option_value' => 'id', 'option_text' => 'name', 'mandatory' => true),

            array('type' => 'text', 'label' => 'Amount Basic', 'name' => 'amount_basic', 'place_holder' => 'Amount Basic', 'mandatory' => true),
            array('type' => 'text', 'label' => 'Amount Discount', 'name' => 'amount_discount', 'place_holder' => 'Amount Discount', 'mandatory' => true),
            array('type' => 'percentage', 'label' => 'Tax', 'name' => 'tax_value', 'place_holder' => 'Tax', 'mandatory' => false),
            array('type' => 'datepicker', 'label' => 'Start Periode', 'name' => 'start_periode', 'place_holder' => 'Start Periode', 'mandatory' => true),
            array('type' => 'datepicker', 'label' => 'End Periode', 'name' => 'end_periode', 'place_holder' => 'End Periode', 'mandatory' => true),
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

        return view('admin.crud.create_or_edit', compact('forms', 'config', 'item', 'uom', 'customerGroup'));
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
            'customerGroup' => 'required',
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
            'customer_group_id' => $request->customerGroup,
            'amount_basic' => $request->amount_basic,
            'amount_discount' => $request->amount_discount,
            'amount' => $amount,
            'tax_value' => $request->tax_value,
            'start_periode' => $request->start_periode,
            'end_periode' => $request->end_periode,
            'created_by' => auth()->user()->id,
        ];
        PriceGroupCust::create($price);

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
        //Form Generator
        $item = Item::all();
        $uom = Uom::all();
        $customerGroup = CustomerGroup::all();

        $forms = [
            array('type' => 'select_option', 'label' => 'Customer Group', 'name' => 'customerGroup', 'variable' => 'customerGroup', 'option_value' => 'id', 'option_text' => 'name', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'SKUID', 'name' => 'item', 'variable' => 'item', 'option_value' => 'id', 'option_text' => 'skuid_item_name', 'mandatory' => true),
            array('type' => 'select_option', 'label' => 'Uom', 'name' => 'uom', 'variable' => 'uom', 'option_value' => 'id', 'option_text' => 'name', 'mandatory' => true),

            array('type' => 'text', 'label' => 'Amount Basic', 'name' => 'amount_basic', 'place_holder' => 'Amount Basic', 'mandatory' => true),
            array('type' => 'text', 'label' => 'Amount Discount', 'name' => 'amount_discount', 'place_holder' => 'Amount Discount', 'mandatory' => true),
            array('type' => 'percentage', 'label' => 'Tax', 'name' => 'tax_value', 'place_holder' => 'Tax', 'mandatory' => false),
            array('type' => 'datepicker', 'label' => 'Start Periode', 'name' => 'start_periode', 'place_holder' => 'Start Periode', 'mandatory' => true),
            array('type' => 'datepicker', 'label' => 'End Periode', 'name' => 'end_periode', 'place_holder' => 'End Periode', 'mandatory' => true),
        ];
        $config = [
            //Form Title
            'title' => 'Update Price',
            //Form Action Using Route Name
            'action' => 'admin.master_data.price.update',
            //Form Method
            'method' => 'PATCH',
            //Back Button Using Route Name
            'back-button' => 'admin.master_data.price.index',
        ];

        $data = PriceGroupCust::find($id);
        // dd($data);

        return view('admin.crud.create_or_edit', compact('forms', 'config', 'item', 'uom', 'customerGroup', 'data'));
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
            'customerGroup' => 'required',
            'item' => 'required',
            'uom' => 'required',
            'amount_basic' => 'required',
            'start_periode' => 'required',
            'end_periode' => 'required',
        ]);

        $amount = $request->amount_basic - $request->amount_discount;
        $item = Item::find($request->item);

        $priceGroupCust = PriceGroupCust::find($request->id);
        $priceGroupCust->customer_group_id = $request->customerGroup;
        $priceGroupCust->skuid = $item->skuid;
        $priceGroupCust->uom_id = $request->uom;
        $priceGroupCust->amount_basic = $request->amount_basic;
        $priceGroupCust->amount_discount = $request->amount_discount;
        $priceGroupCust->amount = $amount;
        $priceGroupCust->tax_value = $request->tax_value;
        $priceGroupCust->start_periode = $request->start_periode;
        $priceGroupCust->end_periode = $request->end_periode;
        $priceGroupCust->updated_by = auth()->user()->id;
        $priceGroupCust->updated_at = Carbon::now();
        $priceGroupCust->save();

        return redirect()->route('admin.master_data.price.index');
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
