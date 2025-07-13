<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Category; // Ganti Kelas dengan Category
use App\Models\Wood; // Ganti Student dengan Wood
use App\Models\User;
use Illuminate\Http\Request;

class PortalController extends Controller
{
    public function index(Request $request)
    {
        return view('pages.portal', [
            'woods' => Wood::count(), // Ganti students menjadi woods
            'criterias' => Criteria::count(),
            'categories' => Category::count(), // Ganti kelases menjadi categories
            'users' => User::count(),
        ]);
    }
}
