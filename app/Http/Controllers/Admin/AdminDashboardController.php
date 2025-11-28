<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // This method simply returns the 'admin.dashboard' view
        // which we created at resources/views/admin/dashboard.blade.php
        return view('admin.dashboard');
    }
}