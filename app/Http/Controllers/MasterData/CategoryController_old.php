<?php

namespace App\Http\Controllers\MasterData;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\DataCollectionResource;
use App\Model\MasterData\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $length = $request->input('length');
        $column = $request->input('column'); //Index
        $orderBy = $request->input('dir', 'asc');
        $searchValue = $request->input('search');

        $query = Category::dataTableQuery($column, $orderBy, $searchValue);
        $data = $query->paginate($length);

        return new DataCollectionResource($data);
    }
}
