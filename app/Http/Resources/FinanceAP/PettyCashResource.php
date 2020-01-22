<?php

namespace App\Http\Resources\FinanceAP;

use App\Model\FinanceAP\RequestFinanceDetail;
use App\Model\MasterData\Vendor;
use App\User;
use App\UserProfile;
use Illuminate\Http\Resources\Json\JsonResource;
use Riskihajar\Terbilang\Facades\Terbilang;

class PettyCashResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $detail = RequestFinanceDetail::where('request_finance_id', $this->finance_request_id)->get();
        $vendor = Vendor::find($this->RequestFinance->vendor_id);
        $user = User::where('name', 'like', $vendor->name)->first();
        if ($user == null) {
            $dept = 'Vendor';
            $nama_rek = $vendor->bank_name;
            $user_name = $vendor->name;
            $no_rek = $vendor->bank_account;
        } else {
            $user_profile = UserProfile::where('user_id', $user->id)->first();
            $dept = isset($user_profile->dept) ? $user_profile->dept : '';
            $nama_rek = isset($user_profile->bank->name) ? $user_profile->bank->name : '';
            $user_name = isset($user->name) ? $user->name : '';
            $no_rek = isset($user_profile->no_rek) ? $user_profile->no_rek : '';
        }
        return [
            'id' => $this->id,
            'status_name' => $this->RequestFinance->status_html,
            'user_request_name' => $user_name,
            'dept' => $dept,
            'address' => $this->RequestFinance->warehouse->address,
            'namaRek' => $nama_rek,
            'noRek' => $no_rek,
            'amount' => $this->amount,
            'terbilang' => Terbilang::make($this->RequestFinance->total) . ' rupiah',
            'no_request' => $this->no_trx,
            'updated_by_name' => $this->updated_by_name,
            'created_by_name' => $this->created_by_name,
            'created_at' => $this->created_at->formatLocalized('%d %B %Y'),
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,

            'details' => RequestFinanceDetailResource::collection($detail),
        ];
    }
}
