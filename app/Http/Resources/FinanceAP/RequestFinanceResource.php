<?php

namespace App\Http\Resources\FinanceAP;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestFinanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'no_request' => $this->no_request,
            'request_date' => $this->request_date,
            'warehouse' => $this->warehouse->address
        ];
    }
}
