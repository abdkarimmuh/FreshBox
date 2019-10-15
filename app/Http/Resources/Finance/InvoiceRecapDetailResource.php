<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceRecapDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'invoice_no' => $this->invoice->invoice_no,
            'send_date' => $this->invoice->delivery_order->do_date->formatLocalized('%d-%b-%y'),
            'price' => $this->invoice->total_price
        ];
    }
}
