<?php

namespace App\Http\Resources\FinanceAP;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ReplenishResource extends JsonResource
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
            'list_proc_id' => $this->list_proc_id,
            'procurement_no' => isset($this->procurement) ? $this->procurement->procurement_no : '',
            'user_procurement' => isset($this->procurement) ? $this->procurement->proc_name : '',
            'vendor' => isset($this->procurement) ? $this->procurement->vendor : '',
            'total_amount' => $this->total_amount,
            'remark' => $this->remark,
            'status_html' => $this->status_html,
            'status' => $this->status,
            'file' => isset($this->procurement) ? $this->procurement->file : '',
            'file_url' => isset($this->procurement) ? url(Storage::url('public/files/procurement/'.$this->procurement->file)) : '',
            'updated_by_name' => $this->updated_by_name,
            'created_by_name' => $this->created_by_name,
            'created_at' => $this->created_at->formatLocalized('%d %B %Y'),
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ];
    }
}
