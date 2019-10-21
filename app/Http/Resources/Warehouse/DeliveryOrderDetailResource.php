<?php

namespace App\Http\Resources\Warehouse;

use Illuminate\Http\Resources\Json\JsonResource;

class DeliveryOrderDetailResource extends JsonResource
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
            'delivery_order_id' => $this->delivery_order_id,
            'skuid' => $this->skuid,
            'sales_order_detail_id' => $this->sales_order_detail_id,
            'item_name' => $this->sales_order_detail->item_name,
            'amount_price' => format_price($this->sales_order_detail->amount_price),
            'qty_order' => $this->sales_order_detail->qty,
            'qty_do' => $this->qty_do,
            'qty_confirm' => $this->qty_confirm,
            'total_amount' => format_price($this->sales_order_detail->amount_price * $this->qty_confirm),
            'uom_id' => $this->uom_id,
            'uom_name' => $this->uom->name,
            'returned' => $this->returned,
            'remark' => $this->remark,
            'created_by' => $this->created_by,
            'created_by_name' => $this->created_by_name,
            'updated_by' => $this->updated_by,
            'updated_at' => $this->updated_at,
            'created_at' => $this->created_at
        ];
    }
}
