<?php

namespace App\Exports;

use App\DeliveryOrder;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use App\Model\Warehouse\DeliveryOrderDetail;
use Maatwebsite\Excel\Concerns\FromCollection;
use App\Http\Resources\Report\ReportSOResource;

class ReportDOExport implements FromView
{
    /**
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function View(): View
    {
        $soDate = date('Y-m-d');
        $data = DB::select(DB::raw("
        SELECT so.sales_order_no AS 'SONO', so.created_at AS 'SODate',
        do_order.delivery_order_no AS 'DONO' , 
        do_order.do_date AS 'DODate', cst.name AS 'CustName',
        cst.customer_code AS 'CUSTID',
            i.skuid AS 'SKUID', i.name_item AS 'ItemName', do_det.qty_do AS 'QTYDO', u.name AS 'Unit' , IFNULL(NULL, so.no_po) AS 'NOPO'
        FROM
                trx_sales_order so,
                trx_delivery_order do_order,
                master_customer cst,
                trx_delivery_order_detail do_det,
                master_uom u,
                master_item i
            WHERE 
                so.id = do_order.sales_order_id and
                cst.id = so.customer_id AND do_order.id = do_det.delivery_order_id
                AND i.skuid = do_det.skuid AND u.id = i.uom_id and so.created_at LIKE  '.$soDate.%'  ;
                        "));

        return view('admin.export.export_report_do', compact('data'));
    }
}
