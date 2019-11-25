<?php

namespace App\Http\Resources\FinanceAP;

use Illuminate\Http\Resources\Json\JsonResource;

class TopUpResource extends JsonResource
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
            'user_proc_name' => $this->user_name,
            'amount' => $this->amount,
            'status' => $this->status_name,
            'remark' => $this->remark,
            'created_at' => $this->created_at,
        ];
    }
}
