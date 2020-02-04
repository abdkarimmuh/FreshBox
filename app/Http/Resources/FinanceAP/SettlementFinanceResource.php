<?php

namespace App\Http\Resources\FinanceAP;

use App\Model\MasterData\Vendor;
use App\User;
use App\UserProfile;
use Illuminate\Http\Resources\Json\JsonResource;

class SettlementFinanceResource extends JsonResource
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
        $vendor = Vendor::find($this->requestFinance->vendor_id);
        if ($vendor->type_vendor == 1) {
            //employee
            $user = User::find($vendor->users_id);
            $user_profile = UserProfile::where('user_id', $user->id)->first();
            $dept = isset($user_profile->dept) ? $user_profile->dept : '';
            $user_name = isset($user->name) ? $user->name : '';
        } else {
            //vendor
            $dept = 'Vendor';
            $user_name = $vendor->name;
        }

        return [
            'id' => $this->id,
            'no_settlement' => $this->no_settlement,
            'no_request' => $this->requestFinance->no_request,
            'request_date' => $this->requestFinance->request_date->formatLocalized('%d %B %Y'),
            'shipping_address' => $this->requestFinance->warehouse->name,
            'status' => $this->status,
            'status_name' => $this->status_html,
            'user_name' => $user_name,
            'dept' => $dept,
            'created_at' => $this->created_at->formatLocalized('%d %B %Y'),
        ];
    }
}
