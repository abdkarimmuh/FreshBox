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
     * @param \Illuminate\Http\Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        $detail = RequestFinanceDetail::where('request_finance_id', $this->finance_request_id)->get();
        $vendor = Vendor::find($this->RequestFinance->vendor_id);
        $user = User::where('name', 'like', $vendor->name)->first();
        if ($user == null) {
            $dept = 'Vendor';
            $bank_name = $vendor->bank_name;
            $user_name = $vendor->name;
            $bank_account = $vendor->bank_account;
        } else {
            $user_profile = UserProfile::where('user_id', $user->id)->first();
            $dept = isset($user_profile->dept) ? $user_profile->dept : '';
            $bank_name = isset($user_profile->bank->name) ? $user_profile->bank->name : '';
            $user_name = isset($user->name) ? $user->name : '';
            $bank_account = isset($user_profile->bank_account) ? $user_profile->bank_account : '';
        }

        return [
            'id' => $this->id,
            'status_name' => $this->RequestFinance->status_html,
            'user_request_name' => $user_name,
            'dept' => $dept,
            'address' => $this->RequestFinance->warehouse->address,
            'bank_name' => $bank_name,
            'bank_account' => $bank_account,
            'amount' => $this->amount,
            'terbilang' => Terbilang::make($this->RequestFinance->total).' rupiah',
            'no_trx' => $this->no_trx,
            'updated_by_name' => $this->updated_by_name,
            'created_by_name' => $this->created_by_name,
            'created_at' => $this->created_at->formatLocalized('%d %B %Y'),
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,

            'details' => RequestFinanceDetailResource::collection($detail),
        ];
    }
}
