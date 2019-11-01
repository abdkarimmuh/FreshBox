<?php

namespace App\Http\Resources\Mobile;

use App\Http\Resources\Procurement\DetailProcurementResource;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailNotificationsResource extends JsonResource
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
            'list_procurement' => $this->Confirm->id,
            // 'id' => $this->Confirm->ListProcturement->id,
            // 'no_proc' => $this->Confirm->ListProcturement->procurement_no,
            // 'user_proc_id' => $this->Confirm->ListProcturement->user_proc_id,
            // 'proc_name' => $this->Confirm->ListProcturement->proc_name,
            // 'vendor' => $this->Confirm->ListProcturement->vendor,
            // 'total_amount' => $this->Confirm->ListProcturement->total_amount,
            // 'payment' => $this->Confirm->ListProcturement->payment,
            // 'file' => $this->Confirm->ListProcturement->file,
            // 'remarks' => $this->Confirm->ListProcturement->remarks,
            // 'status' => $this->Confirm->ListProcturement->status,
            // 'items' => DetailProcurementResource::collection($this->Confirm->ConfirmDetail->ListProcurementDetail),
        ];
    }
}
