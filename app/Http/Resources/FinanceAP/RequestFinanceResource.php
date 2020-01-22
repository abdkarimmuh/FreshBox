<?php

namespace App\Http\Resources\FinanceAP;

use App\Model\MasterData\Vendor;
use App\User;
use App\UserProfile;
use Illuminate\Http\Resources\Json\JsonResource;
use Riskihajar\Terbilang\Facades\Terbilang;

class RequestFinanceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        if($this->request_type==1){
            $requestType = 'Cash';
        }
        else{
            $requestType = 'Advance';
        }

        $vendor = Vendor::find($this->vendor_id);
        $user = User::where('name', 'like', $vendor->name)->first();
        if ($user == null) {
            $dept = 'Vendor';
            $nama_rek = $this->vendor->bank_name;
            $user_name = $this->vendor->name;
            $no_rek = $this->vendor->bank_account;
        } else {
            $user_profile = UserProfile::where('user_id', $user->id)->first();
            $dept = isset($user_profile->dept) ? $user_profile->dept : '';
            $nama_rek = isset($user_profile->nama_rek) ? $user_profile->nama_rek : '';
            $user_name = isset($user->name) ? $user->name : '';
            $no_rek = isset($user_profile->no_rek) ? $user_profile->no_rek : '';
        }
        return [
            'id' => $this->id,
            'no_request' => $this->no_request . '/' . $this->created_at->format('m/Y'),
            'request_date' => $this->request_date->formatLocalized('%d %B %Y'),
            'shipping_address' => $this->warehouse->address,
            // 'status' => isset($this->no_request_confirm) ? 2 : 1,
            'status' =>$this->status,
            'request_type' => $requestType,
            'product_type' =>$this->product_type,
            'user_name' => $user_name,
            'status_name' => $this->status_html,
            // 'status_name' => isset($this->no_request_confirm) ? '<span class="badge badge-success">Confirmed</span>' : '<span class="badge badge-info">Not Confirmed</span>',
            'dept' => $dept,
            'namaRek' => $nama_rek,
            'noRek' => $no_rek,
            'total' => $this->total,
            'terbilang' => Terbilang::make($this->total) . ' rupiah',
            'created_at' => $this->created_at->formatLocalized('%d %B %Y'),
            'created_by_name' => $this->created_by_name
        ];
    }
}
