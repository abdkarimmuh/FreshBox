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
        $qty_assign = 0;

        foreach ($this->AssignListProcurementDetail as $item) {
            $qty_assign += $item->AssignProcurement['qty'];
        }

        return [
            'id' => $this->id,
            'name' => $this->item_name,
            'qty' => intval($this->qty),
            'qty_assign' => intval($qty_assign),
            'qty_minus' => intval($this->qty_minus),
            'uom' => $this->uom_name,
            'uom_assign' => $this->uom_assign_name,
            'amount' => $this->amount,
            'status' => $this->status,
        ];
    }
}
