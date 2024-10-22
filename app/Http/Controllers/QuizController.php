<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Quiz;  
use App\Models\Question;  
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
				'number_of_questions' => 10,
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
        $quiz = Quiz::findOrFail($id); // Find the quiz by its ID
        return view('quiz.edit', compact('quiz'));
    }

	public function myQuizzes()
    {
        // Get the authenticated user's quizzes
        $quizzes = Quiz::where('user_id', auth()->id())->get();

        // Return the view with the quizzes
        return view('quiz.my-quizzes', compact('quizzes'));
    }

}
