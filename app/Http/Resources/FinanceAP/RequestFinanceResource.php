<?php

namespace App\Http\Resources\FinanceAP;

use App\Model\MasterData\Vendor;
use App\User;
use App\UserProfile;
use Illuminate\Http\Resources\Json\JsonResource;

class RequestFinanceResource extends JsonResource
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
        $vendor = Vendor::find($this->vendor_id);
        if ($vendor->type_vendor == 1) {
            //employee
            $user = User::find($vendor->users_id);
            $user_profile = UserProfile::where('user_id', $user->id)->first();
            $dept = isset($user_profile->dept) ? $user_profile->dept : '';
            $user_name = isset($user->name) ? $user->name : '';
            $bank_id = isset($user_profile->bank_id) ? $user_profile->bank_id : '';
            $bank_account = isset($user_profile->bank_account) ? $user_profile->bank_account : '';
        } else {
            //vendor
            $dept = 'Vendor';
            $user_name = $vendor->name;
            $bank_id = $vendor->bank_id;
            $bank_account = $vendor->bank_account;
        }

        return [
            'id' => $this->id,
            'no_request' => $this->no_request,
            'request_date' => $this->request_date->formatLocalized('%d %B %Y'),
            'user_name' => $user_name,
            'dept' => $dept,
            'bank_id' => $bank_id,
            'bank_account' => $bank_account,
            'shipping_address' => $this->warehouse->address,
            'shipping_name' => $this->warehouse->name,
            'status' => $this->status,
            'status_name' => $this->status_html,
            'total' => $this->total,
            'created_at' => $this->created_at->formatLocalized('%d %B %Y'),
            'created_by_name' => $this->created_by_name,
        ];
    }
}
