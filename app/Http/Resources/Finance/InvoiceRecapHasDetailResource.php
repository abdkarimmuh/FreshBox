<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceRecapHasDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $total_amount = 0;
        foreach ($this->invoice_recap_detail as $detail) {
            $total_amount += $detail->total_price;
        }
        return [
            'id' => $this->id,
            'customer_name' => $this->customer->name,
            'up' => $this->customer->pic_customer,
            'recap_invoice_no' => $this->recap_invoice_no,
            'recap_date' => $this->recap_date->formatLocalized('%d %B %Y'),
            'status' => $this->is_paid,
            'total_amount' => $total_amount,
            'invoice_recap_detail' => InvoiceRecapDetailResource::collection($this->invoice_recap_detail)
        ];
    }
}
