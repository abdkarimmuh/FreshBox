<?php

namespace App\Http\Resources\Procurement;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignProcurementResource extends JsonResource
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
        return[
            'id' => $this->id,
            'skuid' => $this->skuid,
            'user_proc_id' => $this->user_proc_id,
            'name' => $this->item_name,
            'qty' => intval($this->qty),
            'uom_id' => $this->uom_id,
            'uom' => $this->uom_name,
        ];
    }
}
