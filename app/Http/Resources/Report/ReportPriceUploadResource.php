<?php

namespace App\Http\Resources\Report;

use App\Model\MasterData\Customer;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class ReportPriceUploadResource extends JsonResource
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
        $customer = Customer::where('customer_group_id', $this->customer_group_id)->get();
        $type_price = '';
        $remarks = '';

        $start = Carbon::createFromFormat('Y-m-d', $this->start_periode);
        $end = Carbon::createFromFormat('Y-m-d', $this->end_periode);
        $nowDate = Carbon::now()->toDateString();

        $days = $start->diffInDays($end);

        if ($days <= 7) {
            $type_price = 'Weekly';
        } elseif ($days <= 17) {
            $type_price = '2 Weekly';
        } elseif ($days <= 32) {
            $type_price = 'Monthly';
        } else {
            $type_price = '2 Monthly';
        }

        if ($end < $nowDate) {
            $remarks = 'Need Upload';
        } else {
            $remarks = 'Updated';
        }

        if ($customer->count() != 0) {
            return [
                'id' => $this->customer_group_id,
                'name' => $this->customer_group_name,
                'total_cust' => $customer->count(),
                'total_skuid' => $this->total_skuid,
                'start_periode' => $this->start_periode,
                'end_periode' => $this->end_periode,
                'type_price' => $type_price,
                'remarks' => $remarks,
            ];
        }
    }
}
