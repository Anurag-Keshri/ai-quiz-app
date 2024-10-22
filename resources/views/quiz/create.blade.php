<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Quiz</title>
</head>
<body>
    <h1>Create a New Quiz</h1>
	@if ($errors->any())
		<div class="alert alert-danger">
			<ul>
				@foreach ($errors->all() as $error)
					<li>{{ $error }}</li>
				@endforeach
			</ul>
		</div>
	@endif

    <form action="/quiz/create" method="POST">
        @csrf

        <!-- AI Model -->
        <label for="model">Select AI Model:</label>
        <select name="model" id="model" required>
            <option value="openai">OpenAI</option>
            <option value="gemini">Gemini</option>
        </select>
        <br><br>

        <!-- Number of Questions -->
        <label for="questions">Number of Questions:</label>
        <input type="number" id="questions" name="number_of_questions" min="1" required>
        <br><br>

        <!-- Number of Options -->
        <label for="options">Number of Options per Question:</label>
        <input type="number" id="options" name="number_of_options" min="2" required>
        <br><br>

        <!-- Difficulty Level -->
        <label for="difficulty">Difficulty Level:</label>
        <select name="difficulty" id="difficulty" required>
            <option value="easy">Easy</option>
            <option value="medium">Medium</option>
            <option value="hard">Hard</option>
        </select>
        <br><br>

        <!-- Depth Level -->
        <label for="depth">Depth Level:</label>
        <select name="depth" id="depth" required>
            <option value="shallow">Shallow</option>
            <option value="deep">Deep</option>
        </select>
        <br><br>

        <!-- Topic (Prompt) -->
        <label for="topic">Topic (Prompt):</label>
        <textarea id="topic" name="topic" rows="5" cols="30" placeholder="Enter the topic or prompt for the quiz" required></textarea>
        <br><br>

        <!-- Submit Button -->
        <button type="submit">Create Quiz</button>
    </form>
</body>
</html>
