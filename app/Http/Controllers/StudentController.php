<?php

namespace App\Http\Controllers;

use App\Models\User; // Assuming your student model is User
use App\Models\Major;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    /**
     * Display a list of students, optionally filtered by major.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $majors = Major::all();
        $majorId = $request->input('major_id');

        // Fetch students based on selected major or get all students
        $students = $majorId 
            ? User::where('major_id', $majorId)->get() 
            : User::all();

        return view('students.index', compact('students', 'majors'));
    }

    /**
     * Show the form to create a new student.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $majors = Major::all();
        return view('students.create', compact('majors'));
    }

    /**
     * Store a newly created student in storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'birthday' => 'required|date',
            'major_id' => 'required|exists:majors,id',
        ]);
    
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'birthday' => $request->birthday,
            'major_id' => $request->major_id,
            'usertype' => 'user', // Assuming 'user' indicates a student
            'password' => bcrypt('temporarypassword'), 
            // 'status' is not needed here if you want it to default to 'inactive'
        ]);
    
        return redirect()->route('students.index')->with('success', 'Student added successfully.');
    }

    /**
     * Show the form to edit the specified student.
     *
     * @param int $id
     * @return \Illuminate\View\View
     */
    public function edit($id)
    {
        $student = User::findOrFail($id);
        $majors = Major::all();
        return view('students.edit', compact('student', 'majors'));
    }

    /**
     * Update the specified student in storage.
     *
     * @param Request $request
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'birthday' => 'required|date',
            'major_id' => 'required|exists:majors,id',
        ]);

        $student = User::findOrFail($id);
        $student->update([
            'name' => $request->name,
            'email' => $request->email,
            'birthday' => $request->birthday,
            'major_id' => $request->major_id,
        ]);

        return redirect()->route('students.index')->with('success', 'Student updated successfully.');
    }

    /**
     * Remove the specified student from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy($id)
    {
        $student = User::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully.');
    }
}
