<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Resources\CategoryResource;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('dashboard');
    }
}
