<?php
namespace App\Http\Controllers;

use App\Models\Major;
use App\Models\Subject;
use Illuminate\Http\Request;

class MajorController extends Controller
{
    public function manage()
    {
        $majors = Major::all();
        $subjects = Subject::with('major')->get();

        return view('majors.manage', compact('majors', 'subjects'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Major::create($request->all());

        return redirect()->route('majors.manage')->with('success', 'Major created successfully.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $major = Major::findOrFail($id);
        $major->update($request->all());

        return redirect()->route('majors.manage')->with('success', 'Major updated successfully.');
    }

    public function destroy($id)
    {
        $major = Major::findOrFail($id);
        $major->delete();

        return redirect()->route('majors.manage')->with('success', 'Major deleted successfully.');
    }

    public function storeSubject(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'major_id' => 'required|exists:majors,id',
        ]);

        Subject::create($request->all());

        return redirect()->route('majors.manage')->with('success', 'Subject created successfully.');
    }

    public function updateSubject(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'major_id' => 'required|exists:majors,id',
        ]);

        $subject = Subject::findOrFail($id);
        $subject->update($request->all());

        return redirect()->route('majors.manage')->with('success', 'Subject updated successfully.');
    }

    public function destroySubject($id)
    {
        $subject = Subject::findOrFail($id);
        $subject->delete();

        return redirect()->route('majors.manage')->with('success', 'Subject deleted successfully.');
    }
}
