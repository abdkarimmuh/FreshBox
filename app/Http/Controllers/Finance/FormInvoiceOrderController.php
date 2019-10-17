<?php

namespace App\Http\Controllers\Finance;

use App\Http\Resources\Finance\InvoiceOrderResource;
use App\Http\Resources\Finance\RekapInvoiceResource;
use App\Http\Resources\Warehouse\DeliveryOrderResource;
use App\Model\Finance\InvoiceOrder;
use App\Model\Marketing\SalesOrder;
use App\Model\MasterData\Customer;
use App\Model\Warehouse\DeliveryOrder;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;

class FormInvoiceOrderController extends Controller
{
    private $VUE_COMPONENT = "vue-component";

    /**
     * Generate Invoice No.
     *
     * @param $id
     * @return InvoiceOrderResource
     */
    public function print($id)
    {
        if (request()->ajax()) {
            if (request()->isMethod('POST')) {
                SalesOrder::where('id', $id)->update(['status' => 7]);
            } else {
                return new InvoiceOrderResource(InvoiceOrder::find($id));
            }
        }
        $config = [
            $this->VUE_COMPONENT => "<print-invoice-order :id='$id'></print-invoice-order>"
        ];
        return view('layouts.vue-view', compact('config'));
    }

    public function multiplePrint(Request $request)
    {
        if ($request->id) {
            $id = $request->id;
            if ($request->ajax()) {
                if ($request->isMethod('POST')) {
                    SalesOrder::whereIn('id', $id)->update(['status' => 7]);
                } else {
                    $invoice_order = InvoiceOrderResource::collection(InvoiceOrder::whereIn('id', $id)->get());
                    return response()->json($invoice_order, 200);
                }
            }
            $config = [
                $this->VUE_COMPONENT => " <multiple-print-invoice-order id='" . json_encode($id) . "'></multiple-print-invoice-order>"
            ];

            return view('layouts.vue-view', compact('config'));
        } else {
            return back();
        }
    }

    public function printRecap(Request $request)
    {

        $config = [
            $this->VUE_COMPONENT => " <print-recap-invoice/>"
        ];

        return view('layouts.vue-view', compact('config'));

    }

}
