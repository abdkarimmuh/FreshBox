<?php

namespace App\Http\Controllers\ApiV1\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\ItemsProcResource;
use App\Http\Resources\SalesOrderDetailResource;
use App\Model\Marketing\SalesOrderDetail;
use Illuminate\Http\Request;

class SalesOrderDetailAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = SalesOrderDetail::all();

        return SalesOrderDetailResource::collection($query);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexAPI()
    {
        $query = SalesOrderDetail::selectRaw('*, sum(sisa_qty_proc) as sisa_qty')
            ->where('status', '<', '4')
            ->where('sisa_qty_proc', '>', '0')
            ->groupBy('skuid')
            ->groupBy('uom_id')
            ->get();

        return ItemsProcResource::collection($query);
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
