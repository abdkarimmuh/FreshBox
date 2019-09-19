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
            'taxt_value' => $this->taxt_value,
            'amount_price' => $this->amount_price,
            'total_amount' => $this->total_amount,
            'notes' => $this->notes,
            'status' => $this->status,
            'item_name' => $this->item_name,
            'uom_name' => $this->uom_name,
        ];
    }
}
