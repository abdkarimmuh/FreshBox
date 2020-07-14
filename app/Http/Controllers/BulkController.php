<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Model\MasterData\Uom;
use App\Model\MasterData\Item;
use App\Model\MasterData\Category;

class BulkController extends Controller
{
    public function bulk_item()
    {
        $url = "https://sheet.best/api/sheets/94f56c0f-6a59-41ca-85f2-8887c4750b18/tabs/mastersku";
        $data_json = json_decode(file_get_contents($url), true);
        $category_id = Category::all();
        $uom_id = Uom::all();
        $category ="";
        $uom ="";
        foreach ($data_json as $key) {

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
