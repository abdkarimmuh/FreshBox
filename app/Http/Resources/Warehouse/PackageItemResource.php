<?php

namespace App\Http\Resources\Warehouse;

use Illuminate\Http\Resources\Json\JsonResource;

class PackageItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        return [

            'id' => $this->id,
            'no_do' => $this->delivery_order->delivery_order_no,
            'customer_name' => $this->delivery_order->customer->name,
            'item_name' => $this->item->name_item,
            'skuid' => $this->item->skuid,
            'qty_do' => $this->qty_do,
            'fullfilment_date' => $this->sales_order_detail->SalesOrder->fulfillment_date->formatLocalized('%d %B %Y'),
        ];
    }
}
