<?php

namespace App\Http\Resources\Procurement;

use Illuminate\Http\Resources\Json\JsonResource;

class ListProcurementResource extends JsonResource
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
            'procurement_no' => $this->procurement_no,
            'user_proc_id' => $this->user_proc_id,
            'proc_name' => $this->proc_name,
            'vemdpr' => $this->vemdpr,
            'total_amount' => $this->total_amount,
            'payment' => $this->payment,
            'file' => $this->file,
            'status' => $this->status,
            'item' => $this->item,
        ];
    }
}
