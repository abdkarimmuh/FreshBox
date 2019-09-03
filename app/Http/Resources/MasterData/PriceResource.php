<?php

namespace App\Http\Resources\MasterData;

use Illuminate\Http\Resources\Json\JsonResource;

class PriceResource extends JsonResource
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
            'skuid' => $this->skuid,
            'uom_id' => $this->uom->id,
            'uom' => $this->uom->name,
            'customer' => $this->customer->name,
            'customer_id' => $this->customer->id,
            'amount' => round($this->amount,2),
            'start_periode' => $this->start_periode,
            'end_periode' => $this->end_periode,
            'remarks' => $this->remarks,
            'item_name' => $this->item->name_item,
            'created_by' => !empty($this->create_by->name) ? $this->create_by->name : null,
            'updated_by' => !empty($this->edit_by->name) ? $this->edit_by->name : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,

        ];
    }
}
