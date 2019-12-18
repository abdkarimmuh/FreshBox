<?php

namespace App\Http\Controllers\ApiV1\FinanceAP;

use App\Http\Controllers\Controller;
use App\Http\Resources\FinanceAP\TopUpResource;
use App\Http\Resources\Mobile\TopUpResource as AppTopUpResource;
use App\Model\FinanceAP\TopUpProc;
use App\UserProc;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TopUpProcAPIController extends Controller
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
        $query = TopUpProc::dataTableQuery($searchValue);
        if ($searchValue) {
            $query = $query->take(20)->paginate(20);
        } else {
            $query = $query->paginate($perPage);
        }

        return TopUpResource::collection($query);
    }

    public function indexApi()
    {
        $date = Carbon::today()->subDays(7);
        $user_proc = UserProc::where('user_id', auth('api')->user()->id)->first();
        $user_proc_id = $user_proc->id;

        $query = TopUpProc::where('user_proc_id', $user_proc_id)
            ->where('created_at', '>=', $date)
            ->orderBy('id', 'desc')
            ->get();

        return AppTopUpResource::collection($query);
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
            'amount' => 'required',
        ]);

        $user_proc = UserProc::where('user_id', auth('api')->user()->id)->first();
        $user_proc_id = $user_proc->id;

        TopUpProc::create([
            'user_proc_id' => $user_proc_id,
            'amount' => $request->amount,
            'status' => 1,
            'remark' => $request->remark,
            'created_by' => auth('api')->user()->id,
        ]);

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
