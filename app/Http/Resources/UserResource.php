<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'dept' => $this->UserProfile->dept,
            'bank_account' => $this->UserProfile->bank_account,
            'bank_name' => $this->UserProfile->bank_name,
        ];
    }
}
