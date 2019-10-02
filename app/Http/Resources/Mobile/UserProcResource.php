<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class UserProcResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'category_id' => $this->category_id,
            'saldo' => $this->procurement->saldo,
            'assign' => AssignListResource::collection($this->procurement->assign_proc)
        ];
    }
}
