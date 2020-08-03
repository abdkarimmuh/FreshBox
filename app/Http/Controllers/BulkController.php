<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\MasterData\Uom;
use App\Model\MasterData\Item;
use App\Model\MasterData\Category;
use App\Model\Marketing\SalesOrder;
use App\Model\Warehouse\DeliveryOrder;
use App\Model\Marketing\SalesOrderDetail;
use App\Model\Warehouse\DeliveryOrderDetail;

class BulkController extends Controller
{
    public function bulk_item()
    {
        $url = "https://sheet.best/api/sheets/94f56c0f-6a59-41ca-85f2-8887c4750b18/tabs/mastersku";
        $data_json = json_decode(file_get_contents($url), true);
        $category_id = Category::all();
        // dd($category_id);
        $uom_id = Uom::all();
        $category ="";
        $uom ="";
        foreach ($data_json as $key) {
            if ($key['Category'] != '' ) {
                foreach ($category_id as $rowcat) {
                    if ($rowcat->name == $key['Category']) {
                        $category = $rowcat->id;
                    } else {
    
                    }
    
                }
    
                foreach ($uom_id as $rowuom) {
                    if ($rowuom->name == $key['Unit']) {
                        $uom = $rowuom->id;
                    } else {
    
                    }
    
                }
                    $data = Item::where('skuid', $key['sku'])->first();
                    if (isset($data)) {
                        $data->name_item = $key['Name'];
                        $data->category_id = $category;
                        $data->uom_id = $uom;
                        $data->origin_id = 1;
                        $data->created_by = 1;
                        $data->created_at = now();
                        $data->updated_at = now();
                        $data->save();
                    } else {
                        Item::Create([
                            'skuid' => $key['sku'],
                            'name_item' => $key['Name'],
                            'category_id' => $category,
                            'uom_id' => $uom,
                            'origin_id' => 1,
                            'created_by' => 1
                        ]);
                    }
                }

            }

            
        }

        public function storeMultiple(Request $request)
        {
            $datenow = date('Y-m-d');
            $dataSOMultiple = SalesOrder::where('status', 1)->get();
            // dd($dataSOMultiple);
            foreach ($dataSOMultiple as $row) {

                $so_details = SalesOrderDetail::where('sales_order_id',  $row->id)->get();
                // dd($so_details);

                $doNo =  str_replace("SO","DO", $row->sales_order_no);
                $data = [
                    'delivery_order_no' => $doNo,
                    'sales_order_id' => $row->id,
                    'customer_id' => $row->customer_id,
                    'do_date' => $row->fulfillment_date,
                    'driver_id' => 1,
                    'remark' => '',
                    'pic_qc' => 2,
                    'created_by' => 1,
                ];
                $delivery_order = DeliveryOrder::create($data);


    
                
                foreach ($so_details as $row_det) {
                    $salesOrderDetails[] = [
                        'delivery_order_id' => $delivery_order->id,
                        'sales_order_detail_id' => $row_det->id,
                        'skuid' => $row_det->skuid,
                        'uom_id' => $row_det->uom_id,
                        'qty_do' => $row_det->qty,
                        'created_by' => $row_det->created_by,
                    ];
                }
                SalesOrder::find($data['sales_order_id'])->update(['status' => 4]);

                DeliveryOrderDetail::insert($salesOrderDetails);
    
            }
        }
}
