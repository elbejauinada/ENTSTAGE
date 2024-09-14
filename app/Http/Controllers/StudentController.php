<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Major;
use Illuminate\Http\Request;
use PDF;
use Illuminate\Support\Facades\Hash;

class StudentController extends Controller
{
    // Display a listing of the students
    public function index(Request $request)
    {
        $majors = Major::all(); // Retrieve all majors
        $students = [];
    
        // If a major is selected, filter students by the selected major
        if ($request->has('major_id') && !empty($request->major_id)) {
            $students = User::where('usertype', 'user')
                            ->where('major_id', $request->major_id)
                            ->get();
        }
    
        return view('students.index', compact('majors', 'students'));
    }
    

    // Show the form for creating a new student
    public function create()
    {
        $majors = Major::all(); // Retrieve all majors
        return view('students.create', compact('majors'));
    }

    // Store a newly created student in storage
// Store a newly created student in storage
public function store(Request $request)
{
    // Validate the input except for the password
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'major_id' => 'required|exists:majors,id',
    ]);

    // Add usertype and set the default password separately
    $validated['usertype'] = 'user'; // Set usertype to 'user'
    $validated['password'] = Hash::make('default-password'); // Set a default hashed password

    // Create the user
    User::create($validated);

    return redirect()->route('students.index')->with('success', 'Student created successfully!');
}

    // Show the form for editing the specified student
    public function edit($id)
    {
        $student = User::where('usertype', 'user')->findOrFail($id);
        $majors = Major::all(); // Retrieve all majors
        return view('students.edit', compact('student', 'majors'));
    }

    // Update the specified student in storage
    public function update(Request $request, $id)
    {
        $student = User::where('usertype', 'user')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'major_id' => 'required|exists:majors,id',
        ]);

        $student->update($validated);

        return redirect()->route('students.index')->with('success', 'Student updated successfully!');
    }

    // Remove the specified student from storage
    public function destroy($id)
    {
        $student = User::where('usertype', 'user')->findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
     // Import PDF facade

     public function exportPDF(Request $request)
     {
         // Retrieve students based on selected major
         $majorId = $request->input('major_id'); // Get the major ID from the request
         $students = User::where('usertype', 'user')
                        ->where('major_id', $majorId)->get(); // Filter students by the selected major
     
         $pdf = PDF::loadView('students.pdf', compact('students'));
         return $pdf->download('students_list.pdf');
     }
     
    
    
}
