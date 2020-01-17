<?php

namespace App\Http\Resources\FinanceAP;

use Illuminate\Http\Resources\Json\JsonResource;

class RequestFinanceDetailResource extends JsonResource
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
            'requestFinanceId' => $this->request_finance_id,
            'itemName' => $this->item_name,
            'typeOfGoods' => $this->type_of_goods,
            'qty' => $this->qty,
            'uom_id' => $this->uom_id,
            'uom_name' => $this->Uom->name,
            'price' => $this->price,
            'ppn' => $this->ppn,
            'total' => $this->total,
            'supplierName' => $this->supplier_name,
            'remarks' => $this->remarks,
            'priceConfirm' => $this->price_confirm,
            'totalConfirm' => $this->total_confirm,
            'qtyConfirm' => $this->qty_confirm,
            'checked' => $this->checked,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
