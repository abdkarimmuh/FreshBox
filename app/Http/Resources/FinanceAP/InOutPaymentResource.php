<?php

namespace App\Http\Resources\FinanceAp;

use Illuminate\Http\Resources\Json\JsonResource;

class InOutPaymentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'status_name' => $this->status_html,
            'vendor_name' => $this->vendor->name,
            'no_rek' => $this->vendor->bank_account,
            'ppn' => $this->vendor->ppn,
            'pph' => $this->vendor->pph,
            'amount' => $this->amount,
            'no_invoice' => $this->no_trx,
            'type_transaction' => $this->type_transaction,
            'updated_by_name' => $this->updated_by_name,
            'created_by_name' => $this->created_by_name,
            'created_at' => $this->created_at->formatLocalized('%d %B %Y'),
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ];
    }
}
