<?php
namespace App\Http\Controllers;
use App\Models\Major;
use App\Models\Subject;
use App\Models\Result;
use App\Models\User;
use Illuminate\Http\Request;

class ResultsController extends Controller
{
    public function select(Request $request)
    {
        $majors = Major::all();
        $subjects = [];
    
        if ($request->has('major_id')) {
            $subjects = Subject::where('major_id', $request->major_id)->get();
        }
    
        $students = [];
        if ($request->has('subject_id')) {
            $students = User::where('major_id', $request->major_id)
                            ->with(['results' => function($query) use ($request) {
                                $query->where('subject_id', $request->subject_id);
                            }])
                            ->get();
        }
    
        return view('results.select', compact('majors', 'subjects', 'students'));
    }
    
    

    public function edit(User $user, Request $request)
    {
        $subjectId = $request->query('subject_id');
        $result = Result::where('user_id', $user->id)->where('subject_id', $subjectId)->first();

        return view('results.edit', compact('user', 'result', 'subjectId'));
    }

    public function update(Request $request, User $user)
    {
        $subjectId = $request->input('subject_id');
        $result = Result::updateOrCreate(
            ['user_id' => $user->id, 'subject_id' => $subjectId],
            ['grade' => $request->input('grade')]
        );
    
        return redirect()->route('results.select', [
            'major_id' => $request->input('major_id'),
            'subject_id' => $subjectId
        ])->with('success', 'Result saved successfully.');
    }
    
    public function destroy(Request $request, User $user)
    {
        $subjectId = $request->input('subject_id');
        $result = Result::where('user_id', $user->id)->where('subject_id', $subjectId)->first();
    
        if ($result) {
            $result->delete();
        }
    
        return redirect()->route('results.select', [
            'major_id' => $request->input('major_id'),
            'subject_id' => $subjectId
        ])->with('success', 'Result deleted successfully.');
    }
    
}

