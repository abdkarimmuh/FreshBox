<?php

namespace App\Http\Resources\FinanceAP;

use App\Model\FinanceAP\RequestFinanceDetail;
use Illuminate\Http\Resources\Json\JsonResource;
use Riskihajar\Terbilang\Facades\Terbilang;

class PettyCashResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $detail = RequestFinanceDetail::where('request_finance_id', $this->finance_request_id)->get();
        return [
            'id' => $this->id,
            'status_name' => $this->RequestFinance->status_html,
            'user_request_name' => $this->RequestFinance->user->name,
            'dept' => $this->RequestFinance->user->UserProfile->dept,
            'address' => $this->RequestFinance->warehouse->address,
            'namaRek' => $this->RequestFinance->user->UserProfile->nama_rek,
            'noRek' => $this->RequestFinance->user->UserProfile->no_rek,
            'amount' => $this->amount,
            'terbilang' => Terbilang::make($this->RequestFinance->total) . ' rupiah',
            'no_request' => $this->no_trx,
            'updated_by_name' => $this->updated_by_name,
            'created_by_name' => $this->created_by_name,
            'created_at' => $this->created_at->formatLocalized('%d %B %Y'),
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,

            'details' => RequestFinanceDetailResource::collection($detail),
        ];
    }
}
