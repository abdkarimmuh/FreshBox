<?php

namespace App\Http\Resources\Mobile;

use Illuminate\Http\Resources\Json\JsonResource;

class NotificationsResource extends JsonResource
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
            'id' => $this->id,
            'status' => $this->status,
            'message' => $this->message,
            'read_at' => $this->read_at,
            'procurement_no' => $this->procurement_no,
            'date' => $this->created_at->toDateString(),
        ];
    }
}
