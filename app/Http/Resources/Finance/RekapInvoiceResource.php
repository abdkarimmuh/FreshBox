<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Resources\Json\JsonResource;

class RekapInvoiceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        $subtotal = 0;
        foreach ($this->invoices as $invoice) {
            $subtotal += $invoice->total_price;
        }
        return [
            'id' => $this->id,
            'customer_name' => $this->name,
            'address' => $this->address,
            'invoices' => InvoiceOrderResource::collection($this->invoices),
            'subtotal' => $subtotal,
        ];
    }
}
