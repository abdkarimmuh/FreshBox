<?php

namespace App\Http\Controllers\Procurement;

use App\Http\Controllers\Controller;
use App\Model\Marketing\SalesOrder;
use App\Model\Procurement\AssignProcurement;
use App\Model\Procurement\UserProcurement;
use Illuminate\Http\Request;

class AssignProcurementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $searchValue = $request->input('search');

        $columns = [
            array('title' => 'Nama', 'field' => 'proc_name'),
            array('title' => 'Nama Barang', 'field' => 'item_name'),
            array('title' => 'Qty', 'field' => 'qty'),
            array('title' => 'UOM', 'field' => 'uom'),
            array('title' => 'Created By', 'field' => 'created_by_name'),
            array('title' => 'Created At', 'field' => 'created_at'),
            array('title' => 'Modified By', 'field' => 'updated_by_name'),
            array('title' => 'Modified At', 'field' => 'updated_at'),
        ];

        $config = [
            //Title Required
            'title' => 'Assign Procurement',
            /*
             * Route Can Be Null
             */
            //Route For Button Add
            // 'route-add' => 'admin.procurement.assign_procurement.create',
            //Route For Button Edit
            // 'route-edit' => 'admin.procurement.assign_procurement.edit',
            //Route For Button Search
            'route-search' => 'admin.procurement.assign_procurement.index',
        ];

        $query = AssignProcurement::dataTableQuery($searchValue);
        $data = $query->paginate(10);

        return view('admin.crud.index', compact('columns', 'data', 'config'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $so_assign = SalesOrder::where('status', 1)->get();
        $users_procurement = UserProcurement::all();

        foreach ($so_assign as $so) {
            foreach ($so->sales_order_details as $detail) {
                foreach ($users_procurement as $user) {
                    if ($user->origin_id == $detail->item->origin_id && $user->category_id == $detail->item->category_id) {
                        AssignProcurement::create([
                            'sales_order_detail_id' => $detail->id,
                            'user_proc_id' => $user->id,
                            'created_by' => auth()->user()->id,
                        ]);
                    }
                }
            }
            $so->status = 2;
            $so->save();
        }

        return redirect('admin/procurement/assign_procurement');
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
