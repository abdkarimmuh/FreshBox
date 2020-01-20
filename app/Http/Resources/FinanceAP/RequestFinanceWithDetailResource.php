<?php

namespace App\Http\Resources\FinanceAP;

use Illuminate\Http\Resources\Json\JsonResource;
use Riskihajar\Terbilang\Facades\Terbilang;

class RequestFinanceWithDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->request_type==1){
            $requestType = 'Cash';
        }
        else{
            $requestType = 'Advance';
        }
        return [
            'id' => $this->id,
            'no_request' => $this->no_request . '/' . $this->created_at->format('m/Y'),
            'request_date' => $this->request_date->formatLocalized('%d %B %Y'),
            'shipping_address' => $this->warehouse->address,
            'request_type' => $requestType,
            'product_type' =>$this->product_type,
            'status' => isset($this->no_request_confirm) ? 2 : 1,
            'user_name' => $this->user->name,
            'status_name' => isset($this->no_request_confirm) ? '<span class="badge badge-success">Confirmed</span>' : '<span class="badge badge-info">Not Confirmed</span>',
            'dept' => $this->user->UserProfile->dept,
            'namaRek' => $this->user->UserProfile->nama_rek,
            'noRek' => $this->user->UserProfile->no_rek,
            'total' => $this->total,
            'terbilang' => Terbilang::make($this->total) . ' rupiah',
            'created_at' => $this->created_at->formatLocalized('%d %B %Y'),
            'created_by_name' => $this->created_by_name,
            'user_id' => $this->user_id,
            'master_warehouse_id' => $this->master_warehouse_id,
            'details' => RequestFinanceDetailResource::collection($this->detail)
        ];
    }
}
