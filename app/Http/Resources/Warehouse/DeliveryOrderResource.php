<?php

namespace App\Http\Resources\Warehouse;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryOrderResource extends JsonResource
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
            'id' => $this->id,
            'delivery_order_no' => $this->delivery_order_no,
            'sales_order_id' => $this->sales_order_id,
            'sales_order_no' => $this->sales_order->sales_order_no,
            'customer_id' => $this->customer_id,
            'customer_name' => $this->customer->name,
            'do_date' => $this->do_date,
            'remark' => $this->remark,
            'driver_id' => $this->driver_id,
            'driver_name' => $this->driver->name,
            'do_details' => DeliveryOrderDetailResource::collection($this->delivery_order_details),
            'created_by_name' => $this->created_by_name
        ];
    }
}
