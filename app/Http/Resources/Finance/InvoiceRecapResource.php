<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceRecapResource extends JsonResource
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
            'customer_name' => $this->customer->name,
            'up' => $this->customer->pic_customer,
            'recap_invoice_no' => $this->recap_invoice_no,
            'recap_date' => $this->recap_date->formatLocalized('%d %B %Y'),
            'is_paid' => $this->is_paid,
            'invoice_recap_detail' => InvoiceRecapDetailResource::collection($this->invoice_recap_detail)
        ];
    }
}
