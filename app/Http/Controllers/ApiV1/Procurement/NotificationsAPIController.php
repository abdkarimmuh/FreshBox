<?php

namespace App\Http\Controllers\ApiV1\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Resources\Mobile\DetailNotificationsItemResource;
use App\Http\Resources\Mobile\DetailNotificationsReplenishResource;
use App\Http\Resources\Mobile\NotificationsResource;
use App\Model\Procurement\Notifications;
use App\UserProc;
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
        $date = Carbon::today()->subDays(7);

        $user_proc = UserProc::where('user_id', auth('api')->user()->id)->first();
        $user_proc_id = $user_proc->id;

        $query = Notifications::where('user_proc_id', $user_proc_id)
            ->where('created_at', '>=', $date)
            ->orderBy('id', 'desc')
            ->get();

        return NotificationsResource::collection($query);
    }

    public function asRead(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $user_proc = UserProc::where('user_id', auth('api')->user()->id)->first();
        $user_proc_id = $user_proc->id;

        $date = Carbon::today()->subDays(7);
        $notification = Notifications::where('user_proc_id', $user_proc_id)->where('id', $request->id)->first();
        $notification->read_at = Carbon::now();
        $notification->save();

        $query = Notifications::where('user_proc_id', $user_proc_id)
            ->where('created_at', '>=', $date)
            ->orderBy('id', 'desc')
            ->get();

        return NotificationsResource::collection($query);
    }

    public function getDetailNotif(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'status' => 'required',
        ]);

        $user_proc = UserProc::where('user_id', auth('api')->user()->id)->first();
        $user_proc_id = $user_proc->id;
        $query = Notifications::where('user_proc_id', $user_proc_id)->where('id', $request->id)->first();

        if ($request->status == 1) {
            return new DetailNotificationsItemResource($query);
        } elseif ($request->status == 2) {
            return new DetailNotificationsReplenishResource($query);
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
        ]);

        $user_proc = UserProc::where('user_id', auth('api')->user()->id)->first();
        $user_proc_id = $user_proc->id;
        $warehouseId = $request->trx_warehouse_confirm_id;
        $status = $request->status;

        DB::select('call insert_notification_procurement(?, ?, ?)', array($user_proc_id, $warehouseId, $status));

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
