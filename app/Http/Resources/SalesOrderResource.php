<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class SalesOrderResource extends JsonResource
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
        $total_price = 0;
        foreach ($this->sales_order_details as $so_detail) {
            $total_price += $so_detail->total_amount;
        }

        return [
            'id' => $this->id,
            'sales_order_no' => $this->sales_order_no,
            'no_po' => $this->no_po,
            'customer_name' => isset($this->customer) ? $this->customer->name : '',
            'source_order_name' => isset($this->SourceOrder) ? $this->SourceOrder->name : '',
            'fulfillment_date' => $this->fulfillment_date->formatLocalized('%d %B %Y'),
            'file' => $this->file,
            'file_url' => url(Storage::url('public/files/salesOrder/'.$this->file)),
            'status' => $this->status,
            'remarks' => $this->remarks,
            'pic_qc' => $this->pic_qc,
            'driver_id' => $this->driver_id,
            'driver_name' => $this->driver_name,
            'so_no_with_cust_name' => $this->so_no_with_cust_name,
            'customer_id' => $this->customer_id,
            'is_printed' => $this->is_printed,
            'source_order_id' => $this->source_order_id,
            'status_name' => $this->status_name,
            'sales_order_details' => SalesOrderDetailResource::collection($this->sales_order_details),
            'total_price' => format_price($total_price),
            'updated_by_name' => $this->updated_by_name,
            'created_by_name' => $this->created_by_name,
            'created_at' => $this->created_at->formatLocalized('%d %B %Y'),
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ];
    }
}
