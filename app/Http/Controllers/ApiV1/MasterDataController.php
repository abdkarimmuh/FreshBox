<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Http\Resources\MasterData\BankAccountResource;
use App\Http\Resources\MasterData\VendorUserResource;
use App\Http\Resources\UserResource;
use App\Model\MasterData\Bank;
use App\Model\MasterData\BankAccout;
use App\Model\MasterData\Category;
use App\Model\MasterData\CustomerGroup;
use App\Model\MasterData\Item;
use App\Model\MasterData\Origin;
use App\Model\MasterData\Vendor;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
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
     * Display a listing of the bank.
     *
     * @return BankAccount[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getBankAccount()
    {
        return BankAccountResource::collection(BankAccout::all());
    }

    /**
     * Display a listing of the Origin.
     *
     * @return Origin[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getOrigin()
    {
        return Origin::all();
    }

    public function getOriginall()
    {
        return Origin::get();
    }

    /**
     * Display a listing of the Category.
     *
     * @return Category[]|\Illuminate\Database\Eloquent\Collection
     */
    public function getCategory()
    {
        return Category::all();
    }

    /**
     * Display a listing of the Customer Group.
     *
     * @return mixed
     */
    public function getCustomerGroup()
    {
        return CustomerGroup::select('id', 'name')->get();
    }

    /**
     * Display a listing of the Users.
     *
     * @return Collection
     */
    public function getUser()
    {
        return DB::table('users')->select('name', 'id')->get();
    }

    /**
     * Display a listing of the Users.
     *
     * @return Collection
     */
    public function getUserVendor($id)
    {
        return new VendorUserResource(Vendor::find($id));
    }

    /**
     * Display a detail of the User.
     *
     * @param $id
     *
     * @return UserResource
     */
    public function getDetailUser($id)
    {
        return new UserResource(User::findOrFail($id));
    }

    /**
     * Display a listing of the Items.
     *
     * @return Collection
     */
    public function getItems()
    {
        return DB::table('master_item')
            ->select('name_item', 'id', 'skuid')
            ->get();
    }

    public function getItemsall()
    {
        return DB::table('master_item')->get();
    }

    public function getuomsall()
    {
        return DB::table('master_uom')->get();
    }

    public function getcategoryall()
    {
        return DB::table('master_category')->get();
    }

    /**
     * Display a detail of the Item.
     *
     * @param $id
     *
     * @return Model|Builder|object
     */
    public function getDetailItem($id)
    {
        return Item::select('name_item', 'id', 'skuid')
            ->where('id', $id)
            ->first();
    }

    /**
     * Display a listing of the Warehouse.
     *
     * @return Collection
     */
    public function getWarehouse()
    {
        return DB::table('master_warehouse')
            ->select('name', 'address', 'id')
            ->get();
    }
}
