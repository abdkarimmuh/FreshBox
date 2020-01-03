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
            'id' => $this->id,
            'sales_order' => $this->sales_order_no.' '.$this->customer_name,
            'item' => $this->item_name.'-'.$this->skuid.' '.intval($this->qty).' '.$this->uom_name,
        ];
    }
}
