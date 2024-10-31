<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Attempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AttemptController extends Controller
{
    public function index(Request $request, Quiz $quiz = null)
    {
		// If quiz is provided, show attempts for that quiz
        if ($quiz) {
			Gate::authorize('viewForQuiz', [Attempt::class, $quiz]);

            $attempts = $quiz->attempts()
                ->with('user')
                ->latest()
                ->paginate(10);
            
            return view('quiz.attempts.index', [
                'attempts' => $attempts,
                'quiz' => $quiz,
            ]);
        }

		Gate::authorize('viewAny', Attempt::class);

        // Otherwise show all attempts by the user
        $attempts = Attempt::query()
            ->where('user_id', auth()->user()->id)
            ->with(['quiz'])
            ->latest()
            ->paginate(10);
        
        return view('quiz.attempts.index', ['attempts' => $attempts]);
    }

    public function create(Quiz $quiz)
    {
		// Authorize the request
		Gate::authorize('create', Attempt::class);

		// If the quizRule has startdate, check if the current date is before the startdate
		if ($quiz->rules->startdate && now()->isBefore($quiz->rules->startdate)) {
			return redirect()
				->route('landing')
				->with('info', 'This quiz has not started yet.');
		}

		// If the quizRule has enddate, check if the current date is after the enddate
		if ($quiz->rules->enddate && now()->isAfter($quiz->rules->enddate)) {
			return redirect()
				->route('landing')
				->with('info', 'This quiz has ended.');
		}

		// If an attempt is not completed, redirect to the attempt
		$attempt = $quiz->attempts()
			->where('user_id', auth()->user()->id)
			->whereNull('completed_at')
			->first();

		if ($attempt) {
			return redirect()
				->route('attempts.show', ['quiz' => $quiz, 'attempt' => $attempt])
				->with('info', 'You have an attempt that is not completed. Redirecting to it now.');
		}

        return view('quiz.attempts.create', ['quiz' => $quiz]);
    }

    public function store(Request $request, Quiz $quiz)
    {
		// Authorize the request
		Gate::authorize('create', Attempt::class);

        $attempt = $quiz->attempts()->create([
            'user_id' => $request->user()->id,
        ]);

        return redirect()->route('attempts.show', [
            'quiz' => $quiz,
            'attempt' => $attempt,
        ]);
    }

    public function show(Quiz $quiz, Attempt $attempt)
    {
		// Authorize the request
		Gate::authorize('view', [$attempt, $quiz]);

        $attempt->load(['answers.option.question.options']);
        
        return view('quiz.attempts.show', [
            'quiz' => $quiz,
            'attempt' => $attempt,
        ]);
    }

	public function submit(Request $request, Quiz $quiz, Attempt $attempt)
	{
		// Authorize the request
		Gate::authorize('submit', $attempt);

        // Ensure the attempt isn't already completed
        if ($attempt->completed_at) {
            return redirect()
                ->route('attempts.show', ['quiz' => $quiz, 'attempt' => $attempt])
                ->with('error', 'This attempt has already been completed.');
        }

        // Validate the incoming answers
        $request->validate([
            'answers' => ['required', 'array'],
            'answers.*' => ['required', 'exists:options,id'],
        ]);

        // Save answers
        foreach ($quiz->questions as $question) {
            $selectedOptionId = $request->input("answers.{$question->id}");
            
            $attempt->answers()->create([
				'attempt_id' => $attempt->id,
                'option_id' => $selectedOptionId,
            ]);
        }

        // Mark attempt as completed
        $attempt->update([
            'completed_at' => now(),
        ]);

        return redirect()
            ->route('attempts.show', ['quiz' => $quiz, 'attempt' => $attempt])
            ->with('success', 'Quiz submitted successfully!');
	}

    public function destroy(Quiz $quiz, Attempt $attempt)
    {
		// Authorize the request
		Gate::authorize('delete', $attempt);

        $attempt->delete();

        return redirect()->route('quiz.attempts.index', ['quiz' => $quiz]);
    }
}