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

        $quiz->load(['questions.options', 'rules', 'attempts']);
        return view('quiz.quizzes.show', compact('quiz'));
    }

    public function edit(Quiz $quiz)
    {
		Gate::authorize('update', $quiz);

        return view('quiz.quizzes.edit', compact('quiz'));
    }

    public function update(Request $request, Quiz $quiz)
    {
		Gate::authorize('update', $quiz);

        // Validate the basic quiz data
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:1000',
            'questions' => 'array',
            'questions.*.id' => 'nullable|exists:questions,id',
            'questions.*.question_text' => 'required|string|max:1000',
            'questions.*.options' => 'required|array|min:2',
            'questions.*.options.*.id' => 'nullable|exists:options,id',
            'questions.*.options.*.option_text' => 'required|string|max:255',
            'questions.*.correct_option' => 'required|integer|min:0',
        ]);

        try {
            \DB::transaction(function () use ($quiz, $validated) {
                // Update quiz basic info
                $quiz->update([
                    'title' => $validated['title'],
                    'description' => $validated['description'],
                ]);

                // Get all current question IDs for later cleanup
                $existingQuestionIds = $quiz->questions()->pluck('id')->toArray();
                $updatedQuestionIds = [];

                // Update or create questions and their options
                foreach ($validated['questions'] as $questionData) {
                    // Handle question
                    $question = isset($questionData['id'])
                        ? $quiz->questions()->findOrFail($questionData['id'])
                        : $quiz->questions()->create(['question_text' => $questionData['question_text']]);

                    $question->update(['question_text' => $questionData['question_text']]);
                    $updatedQuestionIds[] = $question->id;

                    // Get existing option IDs for this question
                    $existingOptionIds = $question->options()->pluck('id')->toArray();
                    $updatedOptionIds = [];

                    // Handle options
                    foreach ($questionData['options'] as $index => $optionData) {
                        $isCorrect = $index == $questionData['correct_option'];
                        
                        $option = isset($optionData['id'])
                            ? $question->options()->findOrFail($optionData['id'])
                            : $question->options()->create([
                                'option_text' => $optionData['option_text'],
                                'is_correct' => $isCorrect,
                            ]);

                        $option->update([
                            'option_text' => $optionData['option_text'],
                            'is_correct' => $isCorrect,
                        ]);

                        $updatedOptionIds[] = $option->id;
                    }

                    // Delete options that weren't included in the update
                    if (!empty($existingOptionIds)) {
                        $question->options()
                            ->whereNotIn('id', $updatedOptionIds)
                            ->delete();
                    }
                }

                // Delete questions that weren't included in the update
                if (!empty($existingQuestionIds)) {
                    $quiz->questions()
                        ->whereNotIn('id', $updatedQuestionIds)
                        ->delete();
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