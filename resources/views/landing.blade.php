<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container text-center mt-5">
        <h1>Welcome to the Quiz App {{ Auth::user() ? Auth::user()->name : '' }}</h1>
        <div class="mt-4">
            <a href="{{ route('quiz.create') }}" class="btn btn-primary btn-lg mx-2">Create Quiz</a>
            <a href="{{ route('quiz.my-quizzes') }}" class="btn btn-info btn-lg mx-2">My Quizzes</a>
        </div>
    </div>
</body>
</html>
