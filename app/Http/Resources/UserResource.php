<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'dept' => $this->UserProfile->dept,
            'no_rek' => $this->UserProfile->no_rek,
            'nama_rek' => $this->UserProfile->nama_rek,
        ];
    }
}
