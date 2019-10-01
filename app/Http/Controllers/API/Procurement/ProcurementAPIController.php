<?php

namespace App\Http\Controllers\API\Procurement;

use App\Http\Controllers\Controller;
use App\Model\Procurement\ListProcurement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProcurementAPIController extends Controller
{
    public function index(Request $request)
    {
        //List Validasi
        $rules = [
            'user_proc_id' => 'required',
            'vendor_id' => 'required|not_in:0',
            'file' => 'required|file64:jpeg,jpg,png,pdf',
            'items.*.qty' => 'required|not_in:0',
        ];
        $request->validate(array_merge($validation_po, $rules));
        //Untuk Mengupload File Ke Storage
        if ($request->file) {
            $file = $request->file;
            @list($type, $file_data) = explode(';', $file);
            @list(, $file_data) = explode(',', $file_data);
            $file_name = $this->generateProcurementNo() . '.' . explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            Storage::disk('local')->put('public/files/' . $file_name, base64_decode($file_data), 'public');
        } else {
            $file_name = '';
        }
        $procurement = [
            'procurement_no' => $this->generateProcurementNo(),
            'user_proc_id' => $request->user_proc_id,
            'vendor_id' => $request->vendor_id,
            'total_amount' => $request->total_amount,
            'file' => $file_name,
        ];
        $procurement = ListProcurement::create($procurement);

        //Untuk Mendapatkan List SKUID
        foreach ($items as $i => $detail) {
            if (isset($detail['qty'])) {
                $skuids[] = $detail['skuid'];
            } else {
                unset($items[$i]);
            }
        }

        foreach ($items as $i => $detail) {
            if (isset($detail['qty'])) {
                $salesOrderDetails[] = [
                    'sales_order_id' => $sales_order->id,
                    'skuid' => $detail['skuid'],
                    'uom_id' => $listItems[$i]->uom_id,
                    'qty' => $detail['qty'],
                    'amount_price' => $listItems[$i]->amount,
                    'total_amount' => $listItems[$i]->amount * $detail['qty'],
                    'notes' => $detail['notes'],
                    'created_by' => $user,
                ];
            } else {
                unset($items[$i]);
            }
        }
        //Insert Data Array Sales Order Details
        ListProcurementD::insert($salesOrderDetails);

        return response()->json($sales_order);

    }

    public function generateProcurementNo()
    {
        $year_month = Carbon::now()->format('ym');
        $latest_sales_order = ListProcurement::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        $get_last_so_no = isset($latest_sales_order->sales_order_no) ? $latest_sales_order->sales_order_no : 'PRO' . $year_month . '00000';
        $cut_string_so = str_replace("SO", "", $get_last_so_no);
        return 'PRO' . ($cut_string_so + 1);
    }
}
