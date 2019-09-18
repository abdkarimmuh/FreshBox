<?php

namespace App\Http\Controllers\Warehouse;

use App\Http\Resources\Warehouse\DeliveryOrderDetailResource;
use App\Http\Resources\Warehouse\DeliveryOrderResource;
use App\Model\Warehouse\DeliveryOrder;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfirmDeliveryOrderController extends Controller
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
            array('title' => 'Delivery Order No', 'field' => 'delivery_order_no'),
            array('title' => 'Customer', 'field' => 'customer_name'),
            array('title' => 'Do Date', 'field' => 'do_date'),
            array('title' => 'Remarks', 'field' => 'remarks'),
            array('title' => 'Driver', 'field' => 'driver_name'),
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
        ];

        $config = [
            //Title Required
            'title' => 'Confirm Delivery Order',
            //Search Route Required
            'route-search' => 'admin.marketing.sales_order.index',
            /**
             * Route Can Be Null, Using Route Name
             */
            //Route For Button Confirm
            'route-confirm' => 'admin.warehouse.confirm_delivery_order.create',
        ];

        $query = DeliveryOrder::dataTableQuery($searchValue);
        $data = $query->paginate(10);

        return view('admin.crud.index', compact('columns', 'data', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $delivery_order = DeliveryOrder::where('id', $id)
            ->whereHas('sales_order', function ($q) {
                $q->where('status', 4);
            })->first();

//        return $delivery_order;

        return  new DeliveryOrderResource($delivery_order);


    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
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
