<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Question;

class QuestionController extends Controller
{
    // ================== CRUD Methods ==================
    public function index()
    {
        $questions = Question::paginate(10);
        return view('questions.index', compact('questions'));
    }

    public function create()
    {
        return view('questions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_option' => 'required|in:A,B,C,D',
        ]);

        Question::create($request->all());
        return redirect()->route('questions.index')->with('success', 'Question added.');
    }

    public function edit(Question $question)
    {
        return view('questions.edit', compact('question'));
    }

    public function update(Request $request, Question $question)
    {
        $request->validate([
            'question' => 'required',
            'option_a' => 'required',
            'option_b' => 'required',
            'option_c' => 'required',
            'option_d' => 'required',
            'correct_option' => 'required|in:A,B,C,D',
        ]);

        $question->update($request->all());
        return redirect()->route('questions.index')->with('success', 'Question updated.');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        return redirect()->route('questions.index')->with('success', 'Question deleted.');
    }

    // ================== Exam Methods ==================

    // Show Start Exam page
    public function startExam()
    {
        $questions = Question::all();
        return view('questions.start', compact('questions'));
    }

    // Submit Exam and show results
    public function submitExam(Request $request)
    {
        $questions = Question::all();
        $score = 0;
        $userAnswers = [];

        foreach ($questions as $q) {
            $answer = $request->input('question_' . $q->id);
            $userAnswers[$q->id] = $answer;

            if ($answer === $q->correct_option) {
                $score++;
            }
        }

        $total = $questions->count();

        return view('questions.result', compact('questions', 'userAnswers', 'score', 'total'));
    }
}
