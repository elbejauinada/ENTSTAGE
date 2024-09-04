<?php
namespace App\Http\Controllers;

use App\Models\Subject;
use App\Models\Major;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'major_id' => 'required|exists:majors,id',
        ]);

        // Create a new subject
        Subject::create($validated);

        return redirect()->route('majors.manage')->with('success', 'Subject added successfully!');
    }

    public function update(Request $request, Subject $subject)
    {
        // Validate the request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'major_id' => 'required|exists:majors,id',
        ]);

        // Update the subject
        $subject->update($validated);

        return redirect()->route('majors.manage')->with('success', 'Subject updated successfully!');
    }

    public function destroy(Subject $subject)
    {
        // Delete the subject
        $subject->delete();

        return redirect()->route('majors.manage')->with('success', 'Subject deleted successfully!');
    }
}
