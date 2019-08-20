<?php

namespace App\Http\Controllers\MasterData;

use App\Http\Resources\DataCollectionResource;
use App\Model\MasterData\Customer;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $orderBy = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $query = Customer::dataTableQuery($column, $orderBy, $searchValue);
        $data = $query->paginate(5);

        return new DataCollectionResource($data);
    }
}
