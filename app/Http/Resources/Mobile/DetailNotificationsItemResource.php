<?php

namespace App\Http\Resources\Mobile;

use App\Http\Resources\Procurement\DetailProcurementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailNotificationsItemResource extends JsonResource
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
            'id' => $this->Confirm->ListProcurement->id,
            'no_proc' => $this->Confirm->ListProcurement->procurement_no,
            'user_proc_id' => $this->Confirm->ListProcurement->user_proc_id,
            'proc_name' => $this->Confirm->ListProcurement->proc_name,
            'vendor' => $this->Confirm->ListProcurement->vendor,
            'total_amount' => $this->Confirm->ListProcurement->total_amount,
            'payment' => $this->Confirm->ListProcurement->payment,
            'file' => $this->Confirm->ListProcurement->file,
            'remarks' => $this->Confirm->ListProcurement->remarks,
            'status' => $this->Confirm->ListProcurement->status,
            'items' => DetailProcurementResource::collection($this->Confirm->ConfirmDetail),
        ];
    }
}
