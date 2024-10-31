<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class QuestionController extends Controller
{
    public function show(Quiz $quiz, Question $question)
    {
		// Authorize the request
		Gate::authorize('view', $question);

		// Get the previous and next question	
		$previousQuestion = $question->previousQuestion();
		$nextQuestion = $question->nextQuestion();

        return view('quiz.questions.show', compact('quiz', 'question', 'previousQuestion', 'nextQuestion'));
    }

    public function create(Quiz $quiz)
    {
		// Authorize the request
		Gate::authorize('create', [Question::class, $quiz]);


        return view('quiz.questions.create', compact('quiz'));
    }

    public function store(Request $request, Quiz $quiz)
    {
		// Authorize the request
		Gate::authorize('create', [Question::class, $quiz]);

		// Validate the request
        $validated = $request->validate([
            'question_text' => 'required|string|max:1000',
            'time_limit' => 'nullable|integer|min:1',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
            'correct_option' => 'required|integer|min:0|max:' . (count($request->options) - 1),
        ]);

        // Create the question
        $question = $quiz->questions()->create([
            'question_text' => $validated['question_text'],
            'time_limit' => $validated['time_limit'],
        ]);

        // Create options
        foreach ($validated['options'] as $index => $optionText) {
            $question->options()->create([
                'option_text' => $optionText,
                'is_correct' => $index === (int) $validated['correct_option'],
            ]);
        }

        return redirect()
            ->route('questions.show', [$quiz, $question])
            ->with('success', 'Question created successfully');
    }

    public function edit(Quiz $quiz, Question $question)
    {
		// Authorize the request
		Gate::authorize('update', $question);

		// Get the previous and next question	
		$previousQuestion = $question->previousQuestion();
		$nextQuestion = $question->nextQuestion();

        return view('quiz.questions.edit', compact('quiz', 'question', 'previousQuestion', 'nextQuestion'));
    }

    public function update(Request $request, Quiz $quiz, Question $question)
    {
		// Authorize the request
		Gate::authorize('update', $question);

		// Validate the request
        $validated = $request->validate([
            'question_text' => 'required|string|max:1000',
            'time_limit' => 'nullable|integer|min:1',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string|max:255',
            'correct_option' => 'required|integer|min:0|max:' . (count($request->options) - 1),
        ]);
		
        // Update the question
        $question->update([
            'question_text' => $validated['question_text'],
            'time_limit' => $validated['time_limit'],
        ]);

        // Delete existing options
        $question->options()->delete();

        // Create new options
        foreach ($validated['options'] as $index => $optionText) {
            $question->options()->create([
                'option_text' => $optionText,
                'is_correct' => $index === (int) $validated['correct_option'],
            ]);
        }

        return redirect()
            ->route('questions.show', [$quiz, $question])
            ->with('success', 'Question updated successfully');
    }

    public function destroy(Quiz $quiz, Question $question)
    {
		// Authorize the request
		Gate::authorize('delete', $question);

        // Delete the question
        $question->delete();

        return redirect()
            ->route('landing') // TODO: Update to the new home page
            ->with('success', 'Question deleted successfully');
    }
}

