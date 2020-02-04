<?php

namespace App\Http\Resources\MasterData;

use App\Model\MasterData\Vendor;
use App\User;
use App\UserProfile;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorUserResource extends JsonResource
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
        $vendor = Vendor::find($this->id);
        if ($vendor->type_vendor == 1) {
            //employee
            $user = User::find($vendor->users_id);
            $user_profile = UserProfile::where('user_id', $user->id)->first();
            $dept = isset($user_profile->dept) ? $user_profile->dept : '';
            $bank_name = $this->bank_name;
            $bank_account = isset($user_profile->bank_account) ? $user_profile->bank_account : '';
        } else {
            //vendor
            $dept = 'Vendor';
            $bank_name = $this->bank_name;
            $bank_account = $this->bank_account;
        }

        return [
          'id' => $this->id,
          'name' => $this->name,
          'dept' => $dept,
          'bank_name' => $bank_name,
          'bank_account' => $bank_account,
        ];
    }
}
