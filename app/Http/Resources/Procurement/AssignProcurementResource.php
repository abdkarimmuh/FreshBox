<?php

namespace App\Http\Resources\Procurement;

use Illuminate\Http\Resources\Json\JsonResource;

class AssignProcurementResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return[
            'id' => $this->id,
            'sales_order_detail_id' => $this->sales_order_detail_id,
            'user_proc_id' => $this->user_proc_id,
            'qty' => $this->qty,
            'uom' => $this->uom,
        ];
    }
}
