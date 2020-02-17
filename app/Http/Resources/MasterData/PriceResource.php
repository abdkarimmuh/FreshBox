<?php

namespace App\Http\Resources\MasterData;

use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
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
            'skuid' => $this->skuid,
            'uom' => isset($this->uom->name) ? $this->uom->name : '',
            'uom_id' => isset($this->uom->id) ? $this->uom->id : 0,
            'amount' => $this->amount,
            'item_name' => isset($this->item->name_item) ? $this->item->name_item : '',

            // 'id' => $this->id,
            // 'skuid' => $this->skuid,
            // 'uom' => $this->uom->name,
            // 'uom_id' => $this->uom->id,
            // 'amount' => round($this->amount, 2),
            // 'item_name' => $this->Item->name_item,
        ];
    }
}
