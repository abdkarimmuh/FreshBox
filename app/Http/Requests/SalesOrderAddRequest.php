<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SalesOrderAddRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
//        return Auth::check() && Auth::user()->can('create-users');
        return true;
    }


    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'remark' => 'required|min:3|max:255',
            'fulfillmentDate' => 'required',
            'customerId' => 'required|not_in:0',
            'sourceOrderId' => 'required',
            'file' => 'required',
            'qty' => 'required'

        ];
    }
}
