<?php

namespace App\Http\Resources\Finance;

use App\Http\Resources\Warehouse\DeliveryOrderDetailResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class InvoiceOrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'do_id' => $this->do_id,
            'customer_name' => $this->customer_name,
            'invoice_no' => $this->invoice_no,
            'delivery_order_no' => $this->delivery_order_no,
            'sales_order_no' => $this->sales_order_no,
            'total_price' => $this->total_price,
            'delivery_orders' => DeliveryOrderDetailResource::collection($this->delivery_order->do_details_not_returned),
            'invoice_date' => $this->invoice_date->formatLocalized('%d %B %Y'),
            'created_at' => $this->created_at
        ];
    }
}
