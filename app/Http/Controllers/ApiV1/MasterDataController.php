<?php

namespace App\Http\Controllers\ApiV1;

use App\Http\Controllers\Controller;
use App\Model\MasterData\Bank;
use App\Model\MasterData\Category;
use App\Model\MasterData\Origin;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    public function getBank()
    {
        return Bank::all();
    }

    public function getOrigin()
    {
        return Origin::all();
    }

    public function getCategory()
    {
        return Category::all();
    }
}
