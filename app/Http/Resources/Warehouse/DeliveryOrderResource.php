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
        $total_amount = 0;
        foreach ($this->delivery_order_details as $do_detail) {
            $total_amount += $do_detail->sales_order_detail->amount_price * $do_detail->qty_confirm;
        }
        return [
            'id' => $this->id,
            'delivery_order_no' => $this->delivery_order_no,
            'do_no_with_cust_name' => $this->delivery_order_no . ' - ' . $this->customer->name,
            'sales_order_id' => $this->sales_order_id,
            'sales_order_no' => $this->sales_order->sales_order_no,
            'customer_id' => $this->customer_id,
            'customer_name' => $this->customer->name,
            'do_date' => $this->do_date->formatLocalized('%d %B %Y'),
            'remark' => $this->remark,
            'driver_id' => $this->driver_id,
            'driver_name' => $this->driver->name,
            'total_amount' => number_format($total_amount, 2),
            'do_details' => DeliveryOrderDetailResource::collection($this->delivery_order_details),
            'do_details_returned' => DeliveryOrderDetailResource::collection($this->do_details_returned),
            'do_details_not_returned' => DeliveryOrderDetailResource::collection($this->do_details_not_returned),
            'created_by_name' => $this->created_by_name
        ];
    }
}
