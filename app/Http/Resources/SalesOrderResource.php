<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SalesOrderResource extends JsonResource
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
            'sales_order_no' => $this->sales_order_no,
            'no_po' => $this->no_po,
            'customer_name' => $this->customer->name,
            'source_order_name' => $this->SourceOrder->name,

            'fulfillment_date' => $this->fulfillment_date,
            'file' => $this->file,
            'status' => $this->status,
            'remarks' => $this->remarks,

            'customer_id' => $this->customer_id,
            'source_order_id' => $this->source_order_id,
            'sales_order_details' => SalesOrderDetailResource::collection($this->sales_order_details),

            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,

        ];
    }
}
