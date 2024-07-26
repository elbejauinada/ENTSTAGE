<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Major;
use App\Models\Subject;
use App\Models\User;
use App\Models\Result;

class ResultController extends Controller
{
    public function select()
    {
        $majors = Major::all();
        $subjects = Subject::all();
        return view('results.select', compact('majors', 'subjects'));
    }
    public function list(Request $request)
    {
        // Validate the request
        $request->validate([
            'major_id' => 'required|exists:majors,id',
            'subject_id' => 'required|exists:subjects,id',
        ]);

        // Fetch the major and subject
        $major = Major::findOrFail($request->major_id);
        $subject = Subject::findOrFail($request->subject_id);

        // Fetch the students and their results for the given major and subject
        $users = User::where('major_id', $major->id)->get();
        $results = Result::where('subject_id', $subject->id)->get();

        // Pass the data to the view
        return view('results.list', compact('major', 'subject', 'users', 'results'));
    }
    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'subject_id' => 'required|exists:subjects,id',
            'grades' => 'required|array',
            'grades.*' => ['numeric', 'min:0', 'max:20'],
        ]);
    
        $subjectId = $request->input('subject_id');
        $grades = $request->input('grades');
    
        foreach ($grades as $userId => $grade) {
            Result::updateOrCreate(
                ['subject_id' => $subjectId, 'user_id' => $userId],
                ['grade' => $grade]
            );
        }
    
        return redirect()->route('results.list')->with('success', 'Grades updated successfully.');
    }
    
    
    public function destroy($id)
    {
        try {
            $result = Result::findOrFail($id);
            $result->delete();
            return redirect()->back()->with('success', 'Le résultat a été supprimé avec succès.');
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return redirect()->back()->with('error', 'Erreur : Résultat introuvable.');
        }
    }

    public function showStudentGrades($user_id, $subject_id)
{
    // Récupérer les résultats pour l'étudiant et la matière spécifiée
    $results = Result::where('user_id', $user_id)
                     ->where('subject_id', $subject_id)
                     ->get();

    // Récupérer les informations de l'étudiant et de la matière
    $student = User::findOrFail($student_id);
    $subject = Subject::findOrFail($subject_id);

    return view('results.view_results', compact('results', 'user_id', 'subject'));
}   
} 

