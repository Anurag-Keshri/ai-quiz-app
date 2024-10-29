<?php

namespace App\Http\Controllers\Quiz;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quiz;  
use App\Models\QuizRule;
use App\Models\Question;
use App\Models\Option;
use App\Models\Attempt;
use App\Models\AttemptAnswer;
use Illuminate\Support\Str;  // For generating a unique quiz ID.
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class QuizController extends Controller
{
    /**
     * Display the form to create a quiz.
     */
    public function create()
    {
        return view('quiz.create'); // The form view
    }

	public function show($id)
	{
		$quiz = Quiz::findOrFail($id);
		// Ensure the current user is the quiz creator
		if ($quiz->author->id !== auth()->id()) {
			abort(403, 'Unauthorized action.');
		}
		return view('quiz.view', compact('quiz'));
	}

	public function take(Request $request, $id)
	{
		$quiz = Quiz::with('questions')->findOrFail($id);
	
		// Check if the quiz is available
		if ($quiz->rules->start_date && now()->lessThan($quiz->rules->start_date)) {
			return redirect()->back()->with('alert', 'Quiz is not available yet.');
		}
		if ($quiz->rules->end_date && now()->greaterThan($quiz->rules->end_date)) {
			return redirect()->back()->with('alert', 'Quiz has ended.');
		}
	
		$attemptId = $request->query('attemptId');
	
		// Handle existing attempt if provided
		if ($attemptId) {
			$attempt = Attempt::where('id', $attemptId)
				->where('quiz_id', $quiz->id)
				->where('user_id', auth()->id())
				->first();
	
			if ($attempt) {
				if ($this->checkIfTimeExceeded($quiz, $attempt)) {
					$attempt->update([
						'completed_at' => now(),
					]);
				}

				if ($attempt->completed_at) {
					return redirect()->route('landing')->with('alert', 'This quiz attempt has already been completed.');
				}
	
				return view('quiz.take', compact('quiz', 'attemptId', 'attempt'));
			}
		}
	
		// Check for existing uncompleted attempt
		$existingAttempt = Attempt::where('quiz_id', $quiz->id)
			->where('user_id', auth()->id())
			->where('completed_at', null)
			->first();
	
		if ($existingAttempt) {
			if ($this->checkIfTimeExceeded($quiz, $existingAttempt)) {
				$existingAttempt->update([
					'completed_at' => now(),
				]);
			}
	
			if ($existingAttempt->isCompleted) {
				return redirect()->route('landing')->with('alert', 'This quiz attempt has already been completed.');
			}
			
			return redirect()->route('quiz.take', ['id' => $quiz->id, 'attemptId' => $existingAttempt->id]);
		}
	
		// Create a new attempt if no uncompleted attempt exists
		$newAttempt = Attempt::create([
			'quiz_id' => $quiz->id,
			'user_id' => auth()->id(),
			'completed_at' => null,
		]);
	
		// Redirect to the new attempt
		return redirect()->route('quiz.take', ['id' => $quiz->id, 'attemptId' => $newAttempt->id]);
	}
	
	// Helper function to check if time has exceeded the limit
	protected function checkIfTimeExceeded($quiz, $attempt)
	{
		$timeLimit = $quiz->rules->time_limit; // Assuming time_limit is in minutes
		if ($timeLimit) {
			$timeLimitInSeconds = $timeLimit * 60; // Convert to seconds
			$startedAtTimestamp = $attempt->created_at->timestamp;
			$currentTimestamp = now()->timestamp;
			$elapsedTime = $currentTimestamp - $startedAtTimestamp;
	
			return $elapsedTime > $timeLimitInSeconds;
		}
	
		return false;
	}

    /**
     * Handle the form submission to create a quiz.
     */
	public function store(Request $request)
	{
		// Validate the form input
		$request->validate([
			'model' => 'required|string|max:255', // Validate AI model selection, will be removed later
			'number_of_questions' => 'required|integer|min:1', // Validate number of questions
			'number_of_options' => 'required|integer|min:2', // Validate number of options per question
			'difficulty' => 'required|string|max:255', // Validate difficulty level
			'depth' => 'required|string|max:255', // Validate depth level
			'topic' => 'required|string|max:255', // Validate topic (prompt)
			'time_limit' => 'required|integer|min:0', // Validate time limit
			'start_datetime' => 'nullable|date', // Validate start datetime
			'end_datetime' => 'nullable|date', // Validate end datetime
		]);

		// Validate if start_datetime is smaller than end_datetime
		if ($request->has('start_datetime') && $request->has('end_datetime') && $request->input('start_datetime') && $request->input('end_datetime')) {
			$startDatetime = strtotime($request->input('start_datetime'));
			$endDatetime = strtotime($request->input('end_datetime'));

			if ($startDatetime >= $endDatetime) {
				return redirect()->back()->withInput()->with('alert', 'Start Date & Time must be earlier than End Date & Time.');
			}
		}

		// Prepare the data for the API call
		$formData = [
			'model' => $request->input('model'),
			'numQuestions' => $request->input('number_of_questions'),
			'numOptions' => $request->input('number_of_options'),
			'difficulty' => $request->input('difficulty'),
			'depth' => $request->input('depth'),
			'topic' => $request->input('topic'),
		];
		
		// Make an API call to ai-quiz-api to generate quiz questions
		$response = Http::withHeaders([
			'Content-Type' => 'application/json',
			'x-api-key' => env('AI_QUIZ_API_KEY'),
		])->post(env('AI_QUIZ_API_URL'), $formData);
	
		// Check if the API call was successful
		if ($response->successful()) {
			// Get the generated quiz data from the response
			$quizData = $response->json();

			$quiz = Quiz::create([
				'user_id' => auth()->id(),
				'title' => $request->input('topic'),
				'description' => 'Default description',
			]);

			QuizRule::create([
				'quiz_id' => $quiz->id,
				'time_limit' => $request->input('time_limit'),
				'show_score' => $request->has('show_score') ? true : false,
				'shuffle_questions' => $request->has('shuffle_questions') ? true : false,
				'shuffle_options' => $request->has('shuffle_options') ? true : false,
				'show_correct_answer' => $request->has('show_correct_answer') ? true : false,
				'start_date' => $request->has('start_date') ? $request->input('start_date') : null,
				'end_date' => $request->has('end_date') ? $request->input('end_date') : null,
			]);
			
			foreach ($quizData as $questionData) {
				$question = Question::create([
					'quiz_id' => $quiz->id,
					'question_text' => $questionData['question'],
					'time_limit' => $request->has('time_limit') ? $request->input('time_limit') : null,
				]);
				
				foreach ($questionData['options'] as $index => $option) {
					Option::create([
						'question_id' => $question->id,
						'option_text' => $option,
						'is_correct' => $index === $questionData['correctAnswer'],
					]);
				}
			}
			
			// Redirect to the edit page with the generated quiz ID
			return redirect()->route('quiz.edit', ['id' => $quiz->id])
				->with('success', 'Quiz created successfully with AI-generated questions!');
		} else {
			// Handle API call failure
			return back()->withErrors(['error' => 'Failed to generate quiz. Please try again later.']);
		}
	}

    /**
     * Display the quiz edit form.
     */
    public function edit($id)
    {
		$quiz = Quiz::findOrFail($id);
		// Ensure the current user is the quiz creator
		if ($quiz->author->id !== auth()->id()) {
			abort(403, 'Unauthorized action.');
		}
        return view('quiz.edit', compact('quiz'));
    }

	public function submit(Request $request, $id)
	{
		// Retrieve the quiz
		$quiz = Quiz::with('questions')->findOrFail($id);
		
		// Check quiz availability (start and end times)
		if ($quiz->rules->start_datetime && now()->lessThan($quiz->rules->start_datetime)) {
			return redirect()->back()->with('alert', 'Quiz is not available yet.');
		}
		if ($quiz->rules->end_datetime && now()->greaterThan($quiz->rules->end_datetime)) {
			return redirect()->back()->with('alert', 'Quiz has ended.');
		}
		
		// Check for an existing attempt
		$attemptId = $request->query('attemptId');
		$attempt = Attempt::where('id', $attemptId)
			->where('quiz_id', $quiz->id)
			->where('user_id', auth()->id())
			->first();

		if ($attempt && $attempt->user->id !== auth()->id()) {
			abort(403, 'Unauthorized access.');
		}
	
		// If no existing attempt is found, create a new attempt
		if (!$attempt) {
			$attempt = Attempt::create([
				'user_id' => auth()->id(),
				'quiz_id' => $quiz->id,
				'completed_at' => null, // Indicate attempt is in progress
			]);
		}
		// Prepare validation rules dynamically for each question
		$validationRules = [];
		foreach ($quiz->questions as $question) {
			$validationRules['question_' . $question->id] = 'required|string';
		}
		// Validate the incoming request
		$request->validate($validationRules);
		
		// Initialize variables for user answers and score calculation
		$attemptAnswers = [];
		
		foreach ($request->all() as $key => $value) {
			if (str_starts_with($key, 'question_')) {
				$optionId = $request->input($key);
				$attemptAnswers[] = ['attempt_id' => $attempt->id, 'option_id' => $optionId];
			}
		}
		
		$attempt->update([
			'completed_at' => now(),
		]);

	
		// Store answers in the database
		foreach ($attemptAnswers as $attemptAnswer) {
			AttemptAnswer::create($attemptAnswer);
		}
	
		// Redirect to results page, passing the `attemptId`
		return redirect()->route('quiz.result', ['id' => $attempt->id]);
	}

	public function showResults($id)
	{
		// Retrieve the quiz attempt by ID
		$attempt = Attempt::with(['quiz', 'answers.option'])->findOrFail($id);

		// Pass the data to the view
		return view('quiz.result', [
			'attempt' => $attempt,
		]);
	}


	public function myQuizzes()
	{
		// Get quizzes created by the authenticated user
		$createdQuizzes = Quiz::where('user_id', auth()->id())->get();
	
		// Get quizzes taken by the authenticated user
		$takenQuizzes = Attempt::with('quiz') // Load associated quiz data
			->where('user_id', auth()->id())
			->whereNotNull('completed_at')
			->get();
	
		return view('quiz.my-quizzes', compact('createdQuizzes', 'takenQuizzes'));
	}

	public function responses($id)
	{
		// Fetch the quiz along with attempts and their related answers and questions
		$quiz = Quiz::findOrFail($id);
	
		// Ensure the current user is the quiz creator
		if ($quiz->author->id !== auth()->id()) {
			abort(403, 'Unauthorized action.');
		}
	
		// Pass the quiz data to the view
		return view('quiz.responses', compact('quiz'));
	}

	public function rules($id)
	{
		$quiz = Quiz::findOrFail($id);
		// Ensure the current user is the quiz creator
		if ($quiz->author->id !== auth()->id()) {
			abort(403, 'Unauthorized action.');
		}
		return view('quiz.rules', compact('quiz'));
	}

	public function updateRules(Request $request, $id)
	{
		// Update the quiz rules
		$quiz = Quiz::findOrFail($id);
		
		// Ensure the current user is the quiz creator
		if ($quiz->author->id !== auth()->id()) {
			abort(403, 'Unauthorized action.');
		}

		// Validate the form input
		$request->validate([
			'time_limit' => 'required|integer|min:1', // Validate time limit
		]);

		$quiz->rules->update([
			'time_limit' => $request->input('time_limit'),
			'shuffle_questions' => $request->has('shuffle_questions') ? true : false,
			'shuffle_options' => $request->has('shuffle_options') ? true : false,
			'show_correct_answer' => $request->has('show_correct_answer') ? true : false,
			'show_score' => $request->has('show_score') ? true : false,
			'start_date' => $request->has('start_date') ? $request->input('start_date') : null,
			'end_date' => $request->has('end_date') ? $request->input('end_date') : null,
		]);
		
		return redirect()->route('landing')
			->with('success', 'Quiz rules updated successfully!');
	}

	public function destroy($id)
	{
		$quiz = Quiz::findOrFail($id);
		// Ensure the current user is the quiz creator
		if ($quiz->author->id !== auth()->id()) {
			abort(403, 'Unauthorized action.');
		}
		$quiz->delete();
		return redirect()->route('quiz.my-quizzes')->with('success', 'Quiz deleted successfully!');
	}
}
