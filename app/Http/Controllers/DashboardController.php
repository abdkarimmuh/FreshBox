<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('admin.dashboard.index');
    }

    public function passport()
    {
        return view('admin.passport');
    }
}
