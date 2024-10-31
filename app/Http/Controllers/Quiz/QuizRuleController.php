<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QuizRuleController extends Controller
{
    public function show(Quiz $quiz)
    {
		// Authorize the request
		Gate::authorize('view', $quiz->rules);

		// Get or create the quiz rules
        $quizRules = $quiz->rules ?? new QuizRule(['quiz_id' => $quiz->id]);

        return view('quiz.quiz-rules.show', compact('quiz', 'quizRules'));
    }

    public function edit(Quiz $quiz)
    {
		// Authorize the request
		Gate::authorize('update', $quiz->rules);

		// Get or create the quiz rules
        $quizRules = $quiz->rules ?? new QuizRule(['quiz_id' => $quiz->id]);

        return view('quiz.quiz-rules.edit', compact('quiz', 'quizRules'));
    }

    public function update(Request $request, Quiz $quiz)
    {
		// Authorize the request
		Gate::authorize('update', $quiz->rules);

		// Validate the request
        $validated = $request->validate([
            'time_limit' => 'nullable|integer|min:1',
            'show_score' => 'boolean',
            'shuffle_options' => 'boolean',
            'shuffle_questions' => 'boolean',
            'show_correct_answer' => 'boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        // Convert checkbox values to boolean
        $validated['show_score'] = $request->has('show_score');
        $validated['shuffle_options'] = $request->has('shuffle_options');
        $validated['shuffle_questions'] = $request->has('shuffle_questions');
        $validated['show_correct_answer'] = $request->has('show_correct_answer');

		// Update or create the quiz rules
        $quiz->rules()->updateOrCreate(
            ['quiz_id' => $quiz->id],
            $validated
        );

        return redirect()
            ->route('quiz_rules.show', $quiz)
            ->with('success', 'Quiz rules updated successfully');
    }
}