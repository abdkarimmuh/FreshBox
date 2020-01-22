<?php

namespace App\Http\Resources\FinanceAp;

use App\Model\FinanceAP\RequestFinance;
use Illuminate\Http\Resources\Json\JsonResource;

class InOutPaymentResource extends JsonResource
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
        if ($this->finance_request_id == null) {
            $source_data = $this->source;
        } else {
            $finance = RequestFinance::find($this->finance_request_id);
            $source_data = $finance->no_request;
        }

        return [
            'id' => $this->id,
            'source_data' => $source_data,
            'type_transaction' => $this->type_html,
            'finance_request_id' => $this->finance_request_id,
            'type' => $this->type_transaction,
            'bank_name' => $this->bank->name,
            'no_rek' => $this->no_rek,
            'amount' => $this->amount,
            'status' => $this->status,
            'status_html' => $this->status_html,
            'remarks' => $this->remarks,
            'updated_by_name' => $this->updated_by_name,
            'created_by_name' => $this->created_by_name,
            'created_at' => $this->created_at->formatLocalized('%d %B %Y'),
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ];
    }
}
