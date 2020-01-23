<?php

namespace App\Http\Resources\FinanceAP;

use App\Model\FinanceAP\RequestFinanceDetail;
use Illuminate\Http\Resources\Json\JsonResource;
use Riskihajar\Terbilang\Facades\Terbilang;

class SettlementFinanceResource extends JsonResource
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
        $total = 0;
        $requestDetail = RequestFinanceDetail::where('request_finance_id', $this->id);
        foreach ($requestDetail as $detail) {
            $total = $total + ($detail->price * $detail->qty + ($detail->price * $detail->qty * $detail->ppn / 100));
        }

        return [
            'id' => $this->id,
            'no_request' => $this->no_request.'/'.$this->created_at->format('m/Y'),
            'request_date' => $this->request_date->formatLocalized('%d %B %Y'),
            'shipping_address' => $this->warehouse->address,
            'status' => isset($this->no_request_confirm) ? 2 : 1,
            'user_name' => $this->user->name,
            'status_name' => isset($this->no_request_confirm) ? '<span class="badge badge-success">Confirmed</span>' : '<span class="badge badge-info">Not Confirmed</span>',
            'dept' => $this->user->UserProfile->dept,
            'namaRek' => $this->user->UserProfile->nama_rek,
            'noRek' => $this->user->UserProfile->no_rek,
            'total' => $total,
            'terbilang' => Terbilang::make($total).' rupiah',
            'created_at' => $this->created_at->formatLocalized('%d %B %Y'),
            'created_by_name' => $this->created_by_name,
        ];
    }
}
