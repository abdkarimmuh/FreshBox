<?php

namespace App\Http\Controllers\ApiV1\Finance;

use App\Http\Controllers\Controller;
use App\Http\Resources\Finance\InvoiceOrderResource;
use App\Http\Resources\Finance\RekapInvoiceResource;
use App\Http\Resources\Warehouse\DeliveryOrderResource;
use App\Model\Finance\InvoiceOrder;
use App\Model\Finance\InvoiceRecap;
use App\Model\Finance\InvoiceRecapDetail;
use App\Model\Marketing\SalesOrder;
use App\Model\MasterData\Customer;
use App\Model\Warehouse\DeliveryOrder;
use Carbon\Carbon;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class InvoiceAPIController extends Controller
{
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;
        $query = InvoiceOrder::dataTableQuery($searchValue);
        if ($request->start && $request->end) {
            $query->whereBetween('invoice_no', [$request->start, $request->end]);
        }

        if ($searchValue) {
            $query = $query->orderBy('invoice_no', 'desc')->paginate($perPage);
        } else {
            $query = $query->orderBy('invoice_no', 'desc')->paginate($perPage);
        }

        return InvoiceOrderResource::collection($query);
    }

    public function create()
    {
        $delivery_order = DeliveryOrder::whereHas('sales_order', function ($q) {
            $q->where('status', 5);
        })->orderBy('delivery_order_no', 'asc')->get();
        return DeliveryOrderResource::collection($delivery_order);
    }

    public function store(Request $request)
    {
        $rules = [
            'invoice_date' => 'required',
            'do_id' => 'required|unique:trx_invoice',
            'customer_id' => 'required'
        ];

        $request->validate($rules);

        $so_id = $request->so_id;
        $invoice_order = [
            'do_id' => $request->do_id,
            'user_id' => $request->user_id,
            'customer_id' => $request->customer_id,
            'invoice_date' => $request->invoice_date,
            'invoice_no' => $this->generateInvoiceNo($request->do_id),
            'created_by' => $request->user_id
        ];
        InvoiceOrder::create($invoice_order);
        SalesOrder::find($so_id)->update(['status' => 6]);

        return response()->json([
            'status' => 'success'
        ], 200);
    }

    public function print(Request $request)
    {
        if (is_array($request->id)) {
            $inv = InvoiceOrder::whereIn('id', $request->id)->orderBy('invoice_no', 'desc')
                ->update(['is_printed' => 1]);
        } elseif ($request->printAll == true) {
            $inv = InvoiceOrder::where('is_printed', 0)
                ->update(['is_printed' => 1]);
        } else {
            $inv = InvoiceOrder::where('id', $request->id)
                ->update(['is_printed' => 1]);
        }

        return response()->json([
            'data' => $inv,
            'status' => 'success'
        ], 200);
    }

    public function show(Request $request)
    {
        if (is_array($request->id)) {
            $inv = InvoiceOrder::whereIn('id', $request->id)->orderBy('invoice_no', 'desc')->get();
            $invoice_order = InvoiceOrderResource::collection($inv);
        } elseif ($request->printAll == true) {
            $inv = InvoiceOrder::where('is_printed', 0)->orderBy('invoice_no', 'desc')->get();
            $invoice_order = InvoiceOrderResource::collection($inv);
        } else {
            $inv = InvoiceOrder::findOrFail($request->id);
            $invoice_order = new InvoiceOrderResource($inv);
        }

        return response()->json($invoice_order, 200);
    }

    /**
     * Generate Recap Invoice
     * @param Request $request
     * @return ResponseFactory|Response
     */
    public function generateRecapInvoice(Request $request)
    {
        $invoices = InvoiceOrder::whereIn('id', $request->id)->get();
        foreach ($invoices as $invoice) {
            $customers_id[] = $invoice->customer_id;
        }
        //Check If customer_id is same
        if (count(array_unique($customers_id)) === 1) {
            $invoice = [
                'customer_id' => $invoices[0]->customer_id,
                'recap_invoice_no' => $this->generateInvoiceRecapNo(),
                'recap_date' => Carbon::now(),
                'created_by' => $request->userId
            ];
            $recap_invoice = InvoiceRecap::create($invoice);
            foreach ($invoices as $invoice) {
                InvoiceRecapDetail::create([
                    'invoice_recap_id' => $recap_invoice->id,
                    'invoice_id' => $invoice->id
                ]);
            }
            return response([
                'status' => true,
                'invoice_recap_id' => $recap_invoice->id
            ]);
        } else {
            return response(['status' => false]);
        }
    }

    public function printRecap(Request $request)
    {
        if (request()->isMethod('POST')) {
            InvoiceOrder::whereIn('id', $request->id)->update(['is_recap' => 1]);
        } else {
            return new RekapInvoiceResource(InvoiceOrder::whereIn('id', $request->id)->get());
        }
    }

    public function generateInvoiceNo($id)
    {
        $deliveryOrder = DeliveryOrder::findOrFail($id);
        $deliveryOrderNo = $deliveryOrder->delivery_order_no;
        $cutStringDO = str_replace("DO", "", $deliveryOrderNo);
        return 'INV' . $cutStringDO;
    }

    public function generateInvoiceRecapNo()
    {
        $year_month = Carbon::now()->format('ym');
        $latest_invoice_recap = InvoiceRecap::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        $get_last_inv_recap_no = isset($latest_invoice_recap->recap_invoice_no) ? $latest_invoice_recap->recap_invoice_no : 'RKP' . $year_month . '00000';
        $cut_string_inv_recap_no = str_replace("RKP", "", $get_last_inv_recap_no);
        return 'RKP' . ($cut_string_inv_recap_no + 1);
    }
}
