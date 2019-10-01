<?php

namespace App\Http\Resources\MasterData;

use Illuminate\Http\Resources\Json\JsonResource;

class CustomerResource extends JsonResource
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
            'customer_code' => $this->customer_code,
            'customer_type_id' => $this->customer_type_id,
            'name' => $this->name,
            'pic_customer' => $this->pic_customer,
            'tlp_pic' => $this->tlp_pic,
            'kodepos'=> $this->kodepos,
            'address' => $this->address
        ];
    }
}
