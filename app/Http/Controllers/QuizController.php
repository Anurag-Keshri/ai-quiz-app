<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;  
use App\Models\Question;  
use App\Models\QuizAttempt;  
use App\Models\QuizAnswer;  
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
		$quiz = Quiz::with('questions')->findOrFail($id); // Retrieve quiz with questions

		return view('quiz.take', compact('quiz')); // Pass quiz data to the view
	}


    /**
     * Handle the form submission to create a quiz.
     */
	public function store(Request $request)
	{
		// Validate the form input
		$request->validate([
			'model' => 'required|string|max:255', // Validate AI model selection
			'number_of_questions' => 'required|integer|min:1', // Validate number of questions
			'number_of_options' => 'required|integer|min:2', // Validate number of options per question
			'difficulty' => 'required|string|max:255', // Validate difficulty level
			'depth' => 'required|string|max:255', // Validate depth level
			'topic' => 'required|string|max:255', // Validate topic (prompt)
		]);
		
	
		// Prepare the data for the API call
		$formData = [
			'model' => $request->input('model'),
			'numQuestions' => $request->input('number_of_questions'), // Use the correct field name
			'numOptions' => $request->input('number_of_options'), // The number of options
			'difficulty' => $request->input('difficulty'),
			'depth' => $request->input('depth'),
			'topic' => $request->input('topic'),
		];
		
	
		// Make an API call to ai-quiz-api to generate quiz questions
		$response = Http::withHeaders([
			'Content-Type' => 'application/json',
			'x-api-key' => 'INTERNAL_API_KEY',
		])->post('http://localhost:3001/api/quiz/generateQuestions', $formData);
	
		// Check if the API call was successful
		if ($response->successful()) {
			// Get the generated quiz data from the response
			$quizData = $response->json();
			$number_of_questions = count($quizData);
			// dd($quizData, count($quizData));
			// Step 1: Create the quiz in the database
			$quiz = Quiz::create([
				'user_id' => auth()->id(), // Store the user ID of the creator
				'title' => $request->input('topic'),
				'description' => 'Default description',
				'number_of_questions' => count($quizData),
				'number_of_options' => $request->input('number_of_options'), // Store options as JSON
			]);
			
			
			// Step 2: Store each question in the questions table
			foreach ($quizData as $questionData) {
				Question::create([
					'quiz_id' => $quiz->id,
					'question_text' => $questionData['question'],
					'options' => json_encode($questionData['options']), // Store options as JSON
					'correct_answer' => $questionData['correctAnswer'],
				]);
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
		$quiz = Quiz::where('id', $id)->where('user_id', auth()->id())->firstOrFail();
        return view('quiz.edit', compact('quiz'));
    }

	public function submit(Request $request, $id)
	{
		// Get the quiz
		$quiz = Quiz::findOrFail($id);
		
		// Prepare validation rules dynamically
		$validationRules = [];
		foreach ($quiz->questions as $question) {
			$validationRules['question_' . $question->id] = 'required|string'; // Expecting an integer index
		}
		
		// Validate the incoming request
		$request->validate($validationRules);
		// dd($validationRules, $request);

		// Initialize an array to hold the user's answers
		$userAnswers = [];
		$score = 0; // Track number of correct answers

		// Loop through each question and store the selected answers
		foreach ($quiz->questions as $question) {
			// Build the dynamic answer key
			$answerKey = 'question_' . $question->id;
	
			// Get the selected answer string
			$selectedAnswer = $request->$answerKey; // This will return the answer string
			
			// Find the index of the selected answer in the options array
			$selectedIndex = array_search($selectedAnswer, json_decode($question->options));
	
			// Check if the selected index matches the correct answer index
			$isCorrect = $selectedIndex === $question->correct_answer;

			// Store the answer details
			$userAnswers[] = [
				'question_id' => $question->id,
				'selected_answer' => $selectedIndex, // Store the selected answer index
				'is_correct' => $isCorrect, // Check if the answer is correct
			];
	
			// Increment score if the answer is correct
			if ($isCorrect) {
				$score++;
			}
		}

		// Create a quiz attempt record
		$quizAttempt = QuizAttempt::create([
			'user_id' => auth()->id(), // Assuming user is authenticated
			'quiz_id' => $quiz->id,
			'score' => $score, // Store the score or number of correct answers
		]);

		// Store user answers in the database
		foreach ($userAnswers as $userAnswer) {
			QuizAnswer::create([
				'quiz_attempt_id' => $quizAttempt->id, // Associate with the quiz attempt
				'question_id' => $userAnswer['question_id'],
				'selected_answer' => $userAnswer['selected_answer'],
				'is_correct' => $userAnswer['is_correct'],
			]);
		}

		// Redirect to results page or any other page
		return redirect()->route('quiz.result', ['id' => $quizAttempt->id]); // Adjust as needed
	}

	public function showResults($id)
	{
		// Retrieve the quiz attempt by ID
		$quizAttempt = QuizAttempt::with(['quiz', 'quizAnswers.question'])->findOrFail($id);

		// Pass the data to the view
		return view('quiz.result', [
			'quizAttempt' => $quizAttempt,
		]);
	}


	public function myQuizzes()
	{
		// Get quizzes created by the authenticated user
		$createdQuizzes = Quiz::where('user_id', auth()->id())->get();
	
		// Get quizzes taken by the authenticated user
		$takenQuizzes = QuizAttempt::with('quiz') // Load associated quiz data
			->where('user_id', auth()->id())
			->get();
	
		return view('quiz.my-quizzes', compact('createdQuizzes', 'takenQuizzes'));
	}

}
