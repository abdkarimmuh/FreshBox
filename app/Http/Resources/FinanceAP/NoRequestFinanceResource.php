<?php

namespace App\Http\Resources\FinanceAP;

use App\Model\MasterData\Vendor;
use App\User;
use Illuminate\Http\Resources\Json\JsonResource;

class NoRequestFinanceResource extends JsonResource
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
            $user_name = isset($user->name) ? $user->name : '';
        } else {
            //vendor
            $user_name = $vendor->name;
        }

        return [
            'id' => $this->id,
            'no_request' => $this->no_request,
            'no_and_requester' => $this->no_request.' - '.$user_name,
        ];
    }
}
