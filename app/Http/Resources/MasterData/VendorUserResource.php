<?php

namespace App\Http\Resources\MasterData;

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
        $user = User::where('name', 'like', $this->name)->first();
        if ($user->isEmpty()) {
            $dept = 'Vendor';
            $nama_rek = $this->bank_name;
            $no_rek = $this->bank_account;
        } else {
            $user_profile = UserProfile::where('user_id', $user->id)->first();
            $dept = isset($user_profile->dept) ? $user_profile->dept : '';
            $nama_rek = isset($user_profile->nama_rek) ? $user_profile->nama_rek : '';
            $no_rek = isset($user_profile->no_rek) ? $user_profile->no_rek : '';
        }

        return [
          'id' => $this->id,
          'name' => $this->name,
          'dept' => $dept,
          'nama_rek' => $nama_rek,
          'no_rek' => $no_rek,
        ];
    }
}
