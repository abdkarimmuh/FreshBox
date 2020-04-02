<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Model\Warehouse\DeliveryOrder;
use App\Model\Warehouse\DeliveryOrderDetail;

class ShipingLabelController extends Controller
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
            array('title' => 'Customer Name', 'field' => 'customer_name'),
            array('title' => 'Barcode', 'field' => 'delivery_order_no', 'type' => 'barcode'),
        ];

        $config = [
            //Title Required
            'title' => 'Shipping Label',
            /*
             * Route Can Be Null
             */
            'route-search' => 'admin.warehouseIn.shippinglable.index',
        ];

        $query = DeliveryOrder::dataTableQuery($searchValue);
        $data = $query->paginate(10);
        return view('admin.crud.index', compact('columns', 'data', 'config'));
    }

    public function show($id)
    {
       return new DeliveryOrderResource(DeliveryOrder::find($id));
    }

}
