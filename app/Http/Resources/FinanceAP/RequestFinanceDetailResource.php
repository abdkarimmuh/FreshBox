<?php

namespace App\Http\Resources\FinanceAP;

use App\Model\FinanceAP\RequestFinanceDetail;
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
        $total = 0;
        $requestDetail = RequestFinanceDetail::where('request_finance_id', $this->id);
        foreach ($requestDetail as $detail) {
            $total = $total + ($detail->price * $detail->qty + ($detail->price * $detail->qty * $detail->ppn / 100));
        }

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
            'total' => $total,
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
