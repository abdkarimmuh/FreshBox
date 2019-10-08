<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SalesOrderDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'sales_order_id' => $this->sales_order_id,
            'skuid' => $this->skuid,
            'uom_id' => $this->uom_id,
            'qty' => $this->qty,
            'sisa_qty_proc' => $this->sisa_qty_proc,
            'taxt_value' => $this->taxt_value,
            'amount_price' => $this->amount_price,
            'total_amount' => $this->total_amount,
            'amount_price_formatted' => number_format($this->amount_price, 2),
            'total_amount_formatted' => number_format($this->total_amount, 2),
            'notes' => $this->notes,
            'status' => $this->status,
            'item_name' => $this->item_name,
            'uom_name' => $this->uom_name,
        ];
    }
}
