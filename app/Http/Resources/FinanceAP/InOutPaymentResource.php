<?php

namespace App\Http\Resources\FinanceAp;

use App\Model\FinanceAP\RequestFinance;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

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
            $file = isset($this->file) ? $this->file : '';
            $file_url = isset($this->file) ? url(Storage::url('public/files/in-out/'.$this->file)) : '';
        } else {
            $finance = RequestFinance::find($this->finance_request_id);
            $source_data = $finance->no_request;
            $file = isset($finance) ? $finance->file : '';
            $file_url = isset($finance) ? url(Storage::url('public/files/request-advance/'.$finance->file)) : '';
        }

        $transaction_date = Carbon::create($this->transaction_date);

        return [
            'id' => $this->id,
            'source_data' => $source_data,
            'file' => $file,
            'file_url' => $file_url,
            'finance_request_id' => $this->finance_request_id,
            'type_transaction' => $this->type_html,
            'option_transaction' => $this->option_html,
            'type' => $this->type_transaction,
            'bank_name' => $this->bank->name,
            'bank_account' => $this->bank_account,
            'amount' => $this->amount,
            'transaction_date' => isset($transaction_date) ? $transaction_date->formatLocalized('%d %B %Y') : '',
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
