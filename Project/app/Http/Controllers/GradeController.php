<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Grade;

class GradeController extends Controller
{
    // Show all grades with term GPA and CGPA
    public function index()
    {
        $grades = Grade::all();

        // Group by term
        $terms = $grades->groupBy('term');
        $termTotals = [];
        $cumulativeCH = 0;
        $cumulativePoints = 0;

        foreach ($terms as $term => $termGrades) {
            $totalCH = $termGrades->sum('credit_hours');
            $totalPoints = $termGrades->sum(function($g) {
                return $g->credit_hours * $this->gradeToPoint($g->grade);
            });

            $gpa = $totalCH ? round($totalPoints / $totalCH, 2) : 0;

            $termTotals[$term] = [
                'totalCH' => $totalCH,
                'gpa' => $gpa,
            ];

            $cumulativeCH += $totalCH;
            $cumulativePoints += $totalPoints;
        }

        $cgpa = $cumulativeCH ? round($cumulativePoints / $cumulativeCH, 2) : 0;

        return view('grades.index', compact('grades', 'termTotals', 'cgpa'));
    }

    // Show create form
    public function create()
    {
        $terms = ['Term 1', 'Term 2', 'Term 3', 'Term 4']; // dropdown
        $grades = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'F'];
        return view('grades.create', compact('terms', 'grades'));
    }

    // Store grade
    public function store(Request $request)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:50',
            'course_title' => 'required|string|max:255',
            'term' => 'required|string|max:50',
            'credit_hours' => 'required|numeric|min:0',
            'grade' => 'required|string|max:2',
        ]);

        Grade::create($request->all());

        return redirect()->route('grades.index')->with('success', 'Grade added successfully.');
    }

    // Edit grade
    public function edit(Grade $grade)
    {
        $terms = ['Term 1', 'Term 2', 'Term 3', 'Term 4'];
        $grades = ['A+', 'A', 'A-', 'B+', 'B', 'B-', 'C+', 'C', 'C-', 'D+', 'D', 'D-', 'F'];
        return view('grades.edit', compact('grade', 'terms', 'grades'));
    }

    // Update grade
    public function update(Request $request, Grade $grade)
    {
        $request->validate([
            'student_name' => 'required|string|max:255',
            'course_code' => 'required|string|max:50',
            'course_title' => 'required|string|max:255',
            'term' => 'required|string|max:50',
            'credit_hours' => 'required|numeric|min:0',
            'grade' => 'required|string|max:2',
        ]);

        $grade->update($request->all());

        return redirect()->route('grades.index')->with('success', 'Grade updated successfully.');
    }

    // Delete grade
    public function destroy(Grade $grade)
    {
        $grade->delete();
        return redirect()->route('grades.index')->with('success', 'Grade deleted successfully.');
    }

    // Convert letter grade to grade point
    private function gradeToPoint($grade)
    {
        $map = [
            'A+' => 4.0,
            'A'  => 4.0,
            'A-' => 3.7,
            'B+' => 3.3,
            'B'  => 3.0,
            'B-' => 2.7,
            'C+' => 2.3,
            'C'  => 2.0,
            'C-' => 1.7,
            'D+' => 1.3,
            'D'  => 1.0,
            'D-' => 0.7,
            'F'  => 0.0,
        ];

        $grade = strtoupper(trim($grade));
        return $map[$grade] ?? 0;
    }
}
