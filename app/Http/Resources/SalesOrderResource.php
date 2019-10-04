<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

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
            'customer_name' => $this->customer->name,
            'source_order_name' => $this->SourceOrder->name,
            'fulfillment_date' => $this->fulfillment_date->formatLocalized('%d %B %Y'),
            'file' => $this->file,
            'file_url' => url('api/v1/marketing/sales_order/download/'.$this->file),
            'status' => $this->status,
            'remarks' => $this->remarks,
            'pic_qc' => $this->pic_qc,
            'so_no_with_cust_name' => $this->so_no_with_cust_name,
            'customer_id' => $this->customer_id,
            'source_order_id' => $this->source_order_id,
            'status_name' => $this->status_name,
            'sales_order_details' => SalesOrderDetailResource::collection($this->sales_order_details),
            'total_price' => number_format($total_price, 2),
            'updated_by_name' => $this->updated_by_name,
            'created_by_name' => $this->created_by_name,
            'created_at' => $this->created_at->formatLocalized('%d %B %Y'),
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
        ];
    }
}
