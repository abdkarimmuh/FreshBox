<?php

namespace App\Http\Resources\Finance;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class InvoiceRecapResource extends JsonResource
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
        foreach ($this->invoice_recap_detail as $detail) {
            $total_amount += $detail->total_price;
        }
        return [
            'id' => $this->id,
            'customer_name' => $this->customer_name,
            'up' => $this->customer->pic_customer,
            'recap_invoice_no' => $this->recap_invoice_no,
            'recapNoWithCustName' => $this->recap_invoice_no . ' - ' . $this->customer_name,
            'recap_date' => $this->recap_date->formatLocalized('%d %B %Y'),
            'total_amount' => $total_amount,
            'paid_date' => $this->paid_date ? $this->paid_date->formatLocalized('%d %B %Y') : null,
            'file' => $this->file,
            'file_url' => url(Storage::url('public/files/recapInvoice/' . $this->file)),
            'submitted_date' => $this->submitted_date ? $this->submitted_date->formatLocalized('%d %B %Y') : null,
            'created_at' => $this->created_at->formatLocalized('%d %B %Y'),
            'created_by_name' => $this->created_by_name,
        ];
    }
}
