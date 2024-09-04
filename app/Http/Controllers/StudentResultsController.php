<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Result; // Assuming you have a Result model

class StudentResultsController extends Controller
{
    public function index()
    {
        $user = Auth::user(); // Get the currently authenticated user
        $results = Result::where('user_id', $user->id)->get(); // Fetch results for the user

        return view('students.results', compact('results'));
    }
}
