<?php

namespace App\Http\Resources\Warehouse;

use Illuminate\Http\Resources\Json\JsonResource;

class PrintLabelResource extends JsonResource
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
            'fullfilment_date' => $this->sales_order_detail->SalesOrder->fulfillment_date->formatLocalized('%d %B %Y'),
            'barcode' => $this->delivery_order->delivery_order_no,
        ];
    }
}
