<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class AdminDashboardController extends Controller
{
    /**
     * Show the admin dashboard.
     */
    public function index()
    {
        $totalUsers = User::count();
        $totalAdmins = User::where('is_admin', true)->count();
        $recentUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact('totalUsers', 'totalAdmins', 'recentUsers'));
    }
}
