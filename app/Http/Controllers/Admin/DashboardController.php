<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Criteria;
use App\Models\Category;
use App\Models\Wood;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        return view('pages.admin.dashboard', [
            'title' => 'Dashboard',
            'woods' => Wood::count(),  // Mengganti Student dengan Wood
            'criterias' => Criteria::count(),
            'categories' => Category::count(),  // Mengganti Kelas dengan Category
            'users' => User::count(),
        ]);
    }
}
