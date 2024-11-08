<?php

namespace App\Http\Controllers\Quiz;

use App\Models\User;
use App\Models\Quiz;
use App\Models\Option;
use App\Models\Attempt;
use App\Models\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class QuizController extends Controller
{
    public function index()
    {
		Gate::authorize('viewAny', Quiz::class);

		$quizzes = $authUserQuizzes = Quiz::latest()->paginate(10);

        return view('quiz.quizzes.index', compact('quizzes', 'authUserQuizzes'));
    }

    public function create()
    {
		Gate::authorize('create', Quiz::class);

        return view('quiz.quizzes.create');
    }

    public function store(Request $request)
    {
		Gate::authorize('create', Quiz::class);

		// Validate the form input
		$request->validate([
			'title' => 'required|string|max:255',
			'description' => 'required|string|max:1000',
			'topic' => 'required|string|max:255', 
			'number_of_questions' => 'required|integer|min:1',
			'number_of_options' => 'required|integer|min:2',
			'difficulty' => 'required|string|max:255',
			'depth' => 'required|string|max:255',
		]);

		// Create the quiz
        $quiz = Auth::user()->quizzes()->create([
			'title' => $request->input('title'),
			'description' => $request->input('description'),
		]);

		// Create default quiz rules
        $quiz->rules()->create([
            'time_limit' => 60, // Default 60 minutes
            'show_score' => true,
            'shuffle_options' => false,
            'shuffle_questions' => false,
            'show_correct_answer' => false,
        ]);

		// Prepare the data for the API call
		$formData = [
			'topic' => $request->input('topic'),
			'numQuestions' => $request->input('number_of_questions'),
			'numOptions' => $request->input('number_of_options'),
			'difficulty' => $request->input('difficulty'),
			'depth' => $request->input('depth'),
		];

		try {
			// Fetch questions from backend api
			$response = Http::withHeaders([
			'Content-Type' => 'application/json',
				'x-api-key' => env('AI_QUIZ_API_KEY'),
			])->post(env('AI_QUIZ_API_URL'), $formData);


			if ($response->successful()) {
				$rawQuestions = $response->json();

				foreach ($rawQuestions as $rawQuestion) {
					$question = Question::create([
						'quiz_id' => $quiz->id,
						'question_text' => $rawQuestion['question'],
					]);

					foreach ($rawQuestion['options'] as $index => $option) {
						Option::create([
							'question_id' => $question->id,
							'option_text' => $option,
							'is_correct' => $index === $rawQuestion['correctAnswer'],
						]);
					}
				}
			} else {
				$quiz->delete();
				return redirect()->back()->with('error', 'Failed to fetch questions from AI-Quiz-API.');
			}
		} catch (\Exception $e) {
			$quiz->delete();
			return redirect()->back()->with('error', 'Error creating quiz. ' . $e->getMessage());
		}

        return redirect()->route('quiz_rules.edit', $quiz)
            ->with('success', 'Quiz created successfully. Please update the quiz rules.');
    }

    public function show(Quiz $quiz)
    {
		Gate::authorize('view', $quiz);

		$quiz->load([
			'questions' => function ($query) {
				$query->orderBy('created_at', 'asc');
			},
			'questions.options' => function ($query) {
				$query->orderBy('created_at', 'asc');
			},
			'rules',
			'attempts'
		]);
        return view('quiz.quizzes.show', compact('quiz'));
    }

    public function edit(Quiz $quiz)
    {
		Gate::authorize('update', $quiz);

		$quiz->load([
			'questions' => function ($query) {
				$query->orderBy('created_at', 'asc');
			},
			'questions.options' => function ($query) {
				$query->orderBy('created_at', 'asc');
			},
			'rules',
			'attempts'
		]);

        return view('quiz.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
		Gate::authorize('update', $quiz);

		// Validate the basic quiz data
        $validated = $request->validate([
			'title' => 'required|string|max:255',
			'description' => 'required|string|max:1000',
			'rules.time_limit' => 'nullable|integer|min:0|max:720',
			'rules.start_date' => 'nullable|date',
			'rules.end_date' => 'nullable|date|after:start_date',
			'rules.show_score' => 'boolean',
			'rules.shuffle_options' => 'boolean',
			'rules.shuffle_questions' => 'boolean',
			'rules.show_correct_answer' => 'boolean',
			'questions' => 'array',
			'questions.*' => 'array',
			'questions.*.question_text' => 'required|string|max:1000',
			'questions.*.options' => 'required|array|min:2',
			'questions.*.options.*' => 'array',
			'questions.*.options.*.option_text' => 'required|string|max:255',
			'questions.*.options.*.is_correct' => 'integer|min:0',
        ]);

        try {
            \DB::transaction(function () use ($quiz, $validated) {
                // Update quiz basic info
                $quiz->update([
                    'title' => $validated['title'],
                    'description' => $validated['description'],
                ]);

				// Convert checkbox values to boolean
				$validated['rules']['show_score'] = array_key_exists('show_score', $validated['rules']);
				$validated['rules']['shuffle_options'] = array_key_exists('shuffle_options', $validated['rules']);
				$validated['rules']['shuffle_questions'] = array_key_exists('shuffle_questions', $validated['rules']);
				$validated['rules']['show_correct_answer'] = array_key_exists('show_correct_answer', $validated['rules']);

				// Update quiz rules
				$quiz->rules()->update(
					[
						'time_limit' => $validated['rules']['time_limit'],
						'start_date' => $validated['rules']['start_date'],
						'end_date' => $validated['rules']['end_date'],
						'show_score' => $validated['rules']['show_score'],
						'shuffle_options' => $validated['rules']['shuffle_options'],
						'shuffle_questions' => $validated['rules']['shuffle_questions'],
						'show_correct_answer' => $validated['rules']['show_correct_answer'],
					]
				);

				// Update questions
				foreach ($validated['questions'] as $questionId => $questionData) {
					$question = Question::find($questionId);
					$question->update([
						'question_text' => $questionData['question_text'],
					]);

					// Update options
					foreach ($question->options as $option) {
						// Update option_text
						$option->update([
							'option_text' => $questionData['options'][$option->id]['option_text'],
						]);

						// Update is_correct
						if (array_key_exists('is_correct', $questionData['options'][$option->id])) {
							$option->update([
								'is_correct' => true,
							]);
						} else {
							$option->update([
								'is_correct' => false,
							]);
						}
					}
				}
            });

            return redirect()
                ->route('quizzes.show', $quiz)
                ->with('success', 'Quiz updated successfully.');

        } catch (\Exception $e) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'Failed to update quiz. ' . $e->getMessage());
        }
    }

    public function destroy(Quiz $quiz)
    {
		Gate::authorize('delete', $quiz);

        $quiz->delete();

        return redirect()->route('landing')
            ->with('success', 'Quiz deleted successfully.');
    }
} 