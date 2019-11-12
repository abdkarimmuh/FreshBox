<?php

namespace App\Http\Resources\Report;

use Illuminate\Http\Resources\Json\JsonResource;

class ReportFinanceARResource extends JsonResource
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
            'skuid' => $this->skuid,
            'uom_name' => $this->uom->name,
            'item_name' => $this->item->name_item,
            'po_no' => $this->sales_order_detail->po_no,
            'item_price' => format_price($this->sales_order_detail->amount_price),
            'total_amount' => format_price($this->total_amount_do),
            'category_name' => $this->sales_order_detail->category_name,
            'delivery_order_no' => $this->delivery_order->delivery_order_no,
            'sales_order_no' => $this->sales_order_detail->sales_order_no,
            'qty' => $this->sales_order_detail->qty,
            'qty_do' => $this->qty_do,
            'so_date' => $this->sales_order_detail->so_date,
            'customer_group_name' => $this->delivery_order->customer->customer_group_name,
            'customer_name' => $this->delivery_order->customer->name,
            'invoice_no' => $this->delivery_order->invoice->invoice_no ??  '',
            'invoice_date' => $this->delivery_order->invoice->invoice_date ??  '',
            'qty_confirm' => $this->qty_confirm ?? '',
        ];
    }
}
