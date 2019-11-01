<?php

namespace App\Http\Controllers\ApiV1\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\NotificationsResource;
use App\Http\Resources\Procurement\DetailProcurementResource;
use App\Model\Procurement\Notifications;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class NotificationsAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $query = Notifications::where('user_proc_id', auth('api')->user()->id)->orderBy('id', 'desc')->take(10)->get();

        return NotificationsResource::collection($query);
    }

    public function asRead(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $notification = Notifications::where('user_proc_id', auth('api')->user()->id)->where('id', $request->id)->first();
        $notification->read_at = Carbon::now();
        $notification->save();

        $query = Notifications::where('user_proc_id', auth('api')->user()->id)->orderBy('id', 'desc')->take(10)->get();

        return NotificationsResource::collection($query);
    }

    public function getDetailNotif(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required',
            'warehouse_confirm_id' => 'required',
        ]);

        if ($request->status == 1) {
            $query = Notifications::where('user_proc_id', auth('api')->user()->id)->where('id', $request->id)->first();

            return DetailProcurementResource::collection($query);
        }
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
        $request->validate([
            'trx_warehouse_confirm_id' => 'required',
            'status' => 'required',
            'message' => 'required',
        ]);

        $userId = auth()->user()->id;
        $warehouseId = $request->trx_warehouse_confirm_id;
        $status = $request->status;
        $message = $request->message;

        DB::select('call insert_notification_procurement(?, ?, ?, ?)', array($userId, $warehouseId, $status, $message));

        return response()->json([
            'status' => 'success',
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
