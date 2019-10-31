<?php

namespace App\Http\Resources\Procurement;

use Illuminate\Http\Resources\Json\JsonResource;

class DetailProcurementResource extends JsonResource
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
            'name' => $this->item_name,
            'qty' => intval($this->qty),
            'qty_minus' => intval($this->qty_minus),
            'uom' => $this->uom_name,
            'amount' => $this->amount,
            'status' => $this->status,
        ];
    }
}
