<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Result;
use App\Models\Subject;
use App\Models\User;
use App\Models\Major; // Assuming you have a Major model

class ResultController extends Controller
{
    /**
     * Show the form for adding results.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // Retrieve all majors
        $majors = Major::all(); 
        
        // Retrieve students and subjects based on the default major
        $students = User::where('usertype', 'user')->get(); 
        $subjects = Subject::all(); 
        
        return view('results.add_results', compact('students', 'subjects', 'majors')); 
    }

    /**
     * Handle the form submission to add results.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'student_id' => 'required|exists:users,id',
            'subject_id' => 'required|exists:subjects,id',
            'grade' => 'required|numeric|min:0|max:20', // Adjust rules as needed
        ]);

        // Create a new result entry in the database
        Result::create([
            'user_id' => $request->student_id,
            'subject_id' => $request->subject_id,
            'grade' => $request->grade,
        ]);

        // Redirect back to the form with a success message
        return redirect()->route('add_results')->with('success', 'Résultat ajouté avec succès.');
    }

    /**
     * Filter students and subjects based on the selected major.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function filterByMajor(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'major_id' => 'required|exists:majors,id',
        ]);

        // Retrieve the selected major
        $majorId = $request->input('major_id');

        // Retrieve students and subjects based on the selected major
        $students = User::where('usertype', 'user')->where('major_id', $majorId)->get();
        $subjects = Subject::where('major_id', $majorId)->get(); // Assuming you have a major_id in the subjects table
        
        // Retrieve all majors for the filter form
        $majors = Major::all();
        
        return view('results.add_results', compact('students', 'subjects', 'majors')); 
    }
        // Show student's results
        public function showResults()
        {
            $userId = auth()->user()->id; // Get the current logged-in user ID
            $results = Result::where('user_id', $userId)
                              ->with('subject') // Eager load subjects
                              ->get();
            
            return view('results.view_results', compact('results'));
        }
}
