<?php

namespace App\Http\Resources\Procurement;

use Illuminate\Http\Resources\Json\JsonResource;

class ListProcurementResource extends JsonResource
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
            'no_proc' => $this->procurement_no,
            'user_proc_id' => $this->user_proc_id,
            'proc_name' => $this->proc_name,
            'vendor' => $this->vendor,
            'total_amount' => $this->total_amount,
            'payment' => $this->payment,
            'file' => $this->file,
            'file_url' => url(Storage::url('public/files/procurement/' . $this->file)),
            'remarks' => $this->remarks,
            'status' => $this->status,
        ];
    }
}
