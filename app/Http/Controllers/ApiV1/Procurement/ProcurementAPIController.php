<?php

namespace App\Http\Controllers\ApiV1\Procurement;

use App\Http\Controllers\Controller;
use App\Http\Resources\Procurement\ListProcurementHasItemsResource;
use App\Http\Resources\Procurement\ListProcurementResource;
use App\Model\Marketing\SalesOrderDetail;
use App\Model\Procurement\AssignProcurement;
use App\Model\Procurement\ListProcurement;
use App\Model\Procurement\ListProcurementDetail;
use App\User;
use App\UserProc;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class ProcurementAPIController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return AnonymousResourceCollection
     */
    public function index()
    {
        $query = ListProcurement::all();
        return ListProcurementResource::collection($query);
    }

    /**
     * @return AnonymousResourceCollection
     */
    public function userProcHasProc()
    {
        $query = ListProcurement::where('user_proc_id', auth('api')->user()->id)->get();

        return ListProcurementHasItemsResource::collection($query);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function store(Request $request)
    {
        // return $request->all();

        $rules = [
            'vendor' => 'required',
            'total_amount' => 'required|not_in:0',
            'payment' => 'required',
            // 'file' => 'required',
            'items' => 'required',
            'items.*.assign_proc_id' => 'required',
            'items.*.qty' => 'required|not_in:0',
            'items.*.uom_id' => 'required',
            'items.*.amount' => 'required',
        ];
        $request->validate($rules);

        $user_proc_id = auth('api')->user()->id;
        $vendor = $request->vendor;
        $total_amount = $request->total_amount;
        $payment = $request->payment;
        $remarks = $request->remarks;
        $items = $request->items;

        if ($request->file) {
            $file = $request->file;
            @list($type, $file_data) = explode(';', $file);
            @list(, $file_data) = explode(',', $file_data);
            $file_name = $this->generateProcOrderNo().'.'.explode('/', explode(':', substr($file, 0, strpos($file, ';')))[1])[1];
            Storage::disk('local')->put('public/files/'.$file_name, base64_decode($file_data), 'public');
        } else {
            $file_name = '';
        }

        $procurement = ListProcurement::create([
            'procurement_no' => $this->generateProcOrderNo(),
            'user_proc_id' => $user_proc_id,
            'vendor' => $vendor,
            'total_amount' => $total_amount,
            'payment' => $payment,
            'file' => $file_name,
            'status' => 1,
            'remarks' => $remarks,
            'created_by' => $user_proc_id,
            'created_at' => Carbon::now(),
        ]);

        foreach ($items as $item) {
            $listProcDetails[] = [
                'trx_list_procurement_id' => $procurement->id,
                'trx_assign_procurement_id' => $item['assign_proc_id'],
                'qty' => $item['qty'],
                'uom_id' => $item['uom_id'],
                'amount' => $item['amount'],
                'status' => 1,
                'created_by' => $user_proc_id,
                'created_at' => Carbon::now(),
            ];

            $assignProcurement = AssignProcurement::find($item['assign_proc_id']);
            $assignProcurement->status = 2;
            $assignProcurement->save();
        }

        ListProcurementDetail::insert($listProcDetails);

        return response()->json([
            'status' => 'success',
        ]);
    }

    public function selectBy($id)
    {
        $query = ListProcurement::where('user_proc_id', auth('api')->user()->id)->where('status', $id)->get();

        return ListProcurementHasItemsResource::collection($query);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return ListProcurementHasItemsResource
     */
    public function show($id)
    {
        $query = ListProcurement::findOrFail($id);

        return new ListProcurementHasItemsResource($query);
    }

    /**
     * @return string
     */
    public function generateProcOrderNo()
    {
        $year_month = Carbon::now()->format('ym');
        $latest_proc = ListProcurement::where(DB::raw("DATE_FORMAT(created_at, '%y%m')"), $year_month)->latest()->first();
        $get_last_proc_no = isset($latest_proc->procurement_no) ? $latest_proc->procurement_no : 'PROC'.$year_month.'00000';
        $cut_string_proc = str_replace('PROC', '', $get_last_proc_no);

        return 'PROC'.($cut_string_proc + 1);
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function storeUserProc(Request $request)
    {
        $rules = [
            'name' => 'required',
            'bank' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'category' => 'required',
            'origin' => 'required',
            'bank_account' => 'required',
        ];
        $request->validate($rules);
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $procurement = UserProc::create([
            'user_id' => $user->id,
            'bank_account' => $request->bank_account,
            'bank_id' => $request->bank,
            'origin_id' => $request->origin,
            'category_id' => $request->category,
            'created_by' => auth('api')->user()->id,
        ]);
        $role = Role::find(4);
        if ($role) {
            $user->assignRole($role);
        }

        return response()->json($procurement);
    }

    /**
     * @param $id
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function updateUserProc($id, Request $request)
    {
        $rules = [
            'name' => 'required',
            'bank' => 'required',
            'email' => 'required|unique:users',
            'password' => 'required',
            'category' => 'required',
            'origin' => 'required',
            'bank_account' => 'required',
        ];
        $request->validate($rules);

        $userProc = UserProc::findOrFail($id);
        $users = User::findOrFail($userProc->user_id);

        $input = $request->all();
        if ($request->password) {
            $input['password'] = bcrypt($input['password']);
        }
        $user = $users->update($input);
        $procurement = $userProc->update([
            'bank_account' => $request->bank_account,
            'bank_id' => $request->bank,
            'origin_id' => $request->origin,
            'category_id' => $request->category,
            'created_by' => auth('api')->user()->id,
        ]);

        return response()->json($procurement);
    }
}
