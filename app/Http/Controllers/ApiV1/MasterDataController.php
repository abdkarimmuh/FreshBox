<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Model\MasterData\Bank;
use App\Model\MasterData\Category;
use App\Model\MasterData\CustomerGroup;
use App\Model\MasterData\Origin;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    /**
     * Display a listing of the User.
     * @return Collection
     */
    public function getUser()
    {
        return DB::table('users')->select('name', 'id')->get();
    }

    /**
     * Display a detail of the User.
     * @param $id
     * @return UserResource
     */
    public function getDetailUser($id)
    {
        return new UserResource(User::findOrFail($id));
    }
}
