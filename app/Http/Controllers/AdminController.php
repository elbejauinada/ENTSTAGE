<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Ensure that this controller is protected by admin middleware
    // to prevent unauthorized access.
    public function __construct()
    {
        $this->middleware('admin'); // Apply admin middleware
    }

    // Method to show the admin dashboard
    public function index()
    {
        return view('admin.dashboard'); // Ensure this view exists
    }
}
