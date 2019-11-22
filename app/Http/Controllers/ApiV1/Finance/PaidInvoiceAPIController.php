<?php

namespace App\Http\Controllers\ApiV1\Finance;

use App\Http\Controllers\Controller;
use App\Http\Resources\Finance\InvoiceRecapResource;
use App\Model\Finance\InvoiceRecap;
use App\Model\Finance\InvoiceRecapDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PaidInvoiceAPIController extends Controller
{

    public function store(Request $request)
    {
        $rules = [
            'invoiceRecapId' => 'required|not_in:0',
            'invoiceRecapDetail' => 'required',
            'invoiceRecapNo' => 'required',
            'invoiceRecapDetail.*.amountPaid' => 'required|not_in:0',
            'paidDate' => 'required'
        ];
        $request->validate($rules);

        $data = [
            'invoiceRecapId' => $request->invoiceRecapId,
            'invoiceRecapDetail' => $request->invoiceRecapDetail,
            'paidDate' => $request->paidDate,
            'file' => $request->file,
            'invoiceRecapNo' => $request->invoiceRecapNo
        ];

        if ($data['file']) {
            $file = $data['file'];
            @list($type, $file_data) = explode(';', $file);
            @list(, $file_data) = explode(',', $file_data);
            $file_name = $data['invoiceRecapNo'] . '.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            Storage::disk('local')->put('public/files/' . $file_name, base64_decode($file_data), 'public');
        } else {
            $file_name = '';
        }

        //Untuk Menginput Sales Order
        $invoice_recap = InvoiceRecap::find($data['invoiceRecapId'])
            ->update([
                'file' => $file_name,
                'paid_date' => $data['paidDate']
            ]);

        foreach ($data['invoiceRecapDetail'] as $i => $detail) {
            InvoiceRecapDetail::where('id', $detail['id'])->update([
                'amount_paid' => $detail['amountPaid'],
            ]);
        }


        return response()->json([
            'status' => 'success',
        ]);
    }

}
