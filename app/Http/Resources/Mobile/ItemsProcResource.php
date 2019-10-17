<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class ItemsProcResource extends JsonResource
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
            'name' => $this->item_name,
            'uom' => $this->uom_name,
            'uom_id' => $this->uom_id,
            'sisa_qty' => $this->sisa_qty
        ];
    }
}
