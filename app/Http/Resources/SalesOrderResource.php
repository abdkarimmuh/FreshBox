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
            'file_url' => url('admin/marketing/form_sales_order/download/' . $this->file),
            'status' => $this->status,
            'remarks' => $this->remarks,
            'so_no_with_cust_name' => $this->so_no_with_cust_name,
            'customer_id' => $this->customer_id,
            'source_order_id' => $this->source_order_id,
            'status_name' => $this->status_name,
            'sales_order_details' => SalesOrderDetailResource::collection($this->sales_order_details),

            "updated_by_name" => $this->updated_by_name,
            "created_by_name" => $this->created_by_name,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,

        ];
    }
}