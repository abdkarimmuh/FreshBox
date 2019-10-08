<?php

namespace App\Http\Controllers\API\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Resources\SalesOrderDetailResource;
use App\Model\Marketing\SalesOrderDetail;
use App\Model\Procurement\AssignProcurement;
use Illuminate\Http\Request;

class ItemAPIProcurement extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchValue = $request->input('query');
        $perPage = $request->perPage;
        $query = SalesOrderDetail::dataTableQuery($searchValue);
        if ($searchValue) {
            $query = $query->orderBy('sales_order_id', 'desc')->take(20)->paginate(20);
        } else {
            $query = $query->orderBy('sales_order_id', 'desc')->paginate($perPage);
        }

        return SalesOrderDetailResource::collection($query);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //List Validasi
        $rules = [
            'skuid' => 'required',
            'user_proc_id' => 'required',
            'qty' => 'required|not_in:0',
        ];
        $request->validate(array_merge($rules));

        $skuid = $request->skuid;
        $user_proc_id = $request->user_proc_id;
        $qty_all = $request->qty;

        $sales_order_detail = SalesOrderDetail::where('status', 1);

        foreach ($sales_order_detail as $item) {
            //Untuk Melakukan assign procurement
            $assign_procurement = AssignProcurement::create([
                'sales_order_detail_id' => $item->id,
                'user_proc_id' => $user_proc_id,
                'qty' => $qty_all,
                'created_by' => $user_proc_id,
                'created_at' => Carbon::now(),
            ]);
        }


        return response()->json([
            'status' => 'success',
            'data' => $assign_procurement
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
    }
}
