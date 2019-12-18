<?php

namespace App\Http\Resources\Mobile;

use App\Model\FinanceAP\Replenish;
use Illuminate\Http\Resources\Json\JsonResource;

class DetailNotificationsReplenishResource extends JsonResource
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
        $listProcurementId = $this->Confirm->ListProcurement->id;
        $replenish = Replenish::where('list_proc_id', $listProcurementId)->first();

        return [
            'id' => $this->Confirm->ListProcurement->id,
            'no_proc' => $this->Confirm->ListProcurement->procurement_no,
            'proc_name' => $this->Confirm->ListProcurement->proc_name,
            'vendor' => $this->Confirm->ListProcurement->vendor,
            'total_amount' => $this->Confirm->ListProcurement->total_amount,
            'payment' => $this->Confirm->ListProcurement->payment,
            'remarks' => $replenish->remark,
            'status' => $this->Confirm->ListProcurement->status,
        ];
    }
}
