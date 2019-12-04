<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Model\MasterData\Bank;
use App\Model\MasterData\Category;
use App\Model\MasterData\CustomerGroup;
use App\Model\MasterData\Origin;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    /**
     * Display a listing of the bank.
     *
     * @return Bank[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getBank()
    {
        return Bank::all();
    }

    /**
     * Display a listing of the Origin.
     * @return Origin[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getOrigin()
    {
        return Origin::all();
    }

    /**
     * Display a listing of the Category.
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCategory()
    {
        return Category::all();
    }

    /**
     * Display a listing of the Customer Group.
     * @return mixed
     */
    public function getCustomerGroup()
    {
        return CustomerGroup::select('id', 'name')->get();
    }
}
