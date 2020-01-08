<?php

namespace App\Http\Resources\Procurement;

use App\Model\Procurement\ListProcurement;
use App\Model\Procurement\ListProcurementDetail;
use App\Model\WarehouseIn\ConfirmDetail;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class ListProcurementHasItemsResource extends JsonResource
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
        $listProcurement = ListProcurement::where('procurement_no', 'like', '%'.$this->procurement_no.'%')->get();

        foreach ($listProcurement as $procurement) {
            $procDetail = ListProcurementDetail::where('trx_list_procurement_id', $procurement->id)->get();
            foreach ($procDetail as $item) {
                $confirm = ConfirmDetail::where('list_proc_detail_id', $item->id)->first();

                $detailProcurement[] = [
                    'id' => $item->id,
                    'name' => $item->item_name,
                    'qty' => $item->qty - $item->qty_minus,
                    'uom' => $item->uom_name,
                    'confirm_date' => $confirm->created_at->formatLocalized('%d %B %Y'),
                ];
            }
        }

        return [
            'id' => $this->id,
            'no_proc' => $this->procurement_no,
            'user_proc_id' => $this->user_proc_id,
            'proc_name' => $this->proc_name,
            'vendor' => $this->vendor,
            'total_amount' => $this->total_amount,
            'payment' => $this->payment,
            'file' => $this->file,
            'file_url' => url(Storage::url('public/files/procurement/'.$this->file)),
            'remarks' => $this->remarks,
            'status' => $this->status,
            'items' => $detailProcurement,
        ];
    }
}
