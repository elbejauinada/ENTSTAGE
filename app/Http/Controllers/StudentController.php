<?php
namespace App\Http\Controllers;

use App\Models\User; // Assuming User model is used for students
use Illuminate\Http\Request;

class StudentController extends Controller
{
    // Display the list of students
    public function index()
    {
        $students = User::all(); // Fetch all students
        return view('students.index', compact('students'));
    }

    // Show the form for creating a new student
    public function create()
    {
        return view('students.create');
    }

    // Store a newly created student in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
        ]);

        return redirect()->route('students.index')->with('success', 'Étudiant ajouté avec succès.');
    }

    // Show the form for editing the specified student
    public function edit(User $student)
    {
        return view('students.edit', compact('student'));
    }

    // Update the specified student in the database
    public function update(Request $request, User $student)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $student->id,
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        $student->name = $request->input('name');
        $student->email = $request->input('email');

        if ($request->filled('password')) {
            $student->password = bcrypt($request->input('password'));
        }

        $student->save();

        return redirect()->route('students.index')->with('success', 'Étudiant mis à jour avec succès.');
    }

    // Remove the specified student from the database
    public function destroy(User $student)
    {
        $student->delete();
        return redirect()->route('students.index')->with('success', 'Étudiant supprimé avec succès.');
    }
}
