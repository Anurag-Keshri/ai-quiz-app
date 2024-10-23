<h1>Welcome to the Quiz App</h1>

<div>
    <a href="/quiz/create"><button>Create Quiz</button></a>

    <form id="takeQuizForm" method="GET" onsubmit="updateFormAction()">
        <input type="number" id="quiz_id" placeholder="Enter the quiz ID" required>
        <button type="submit">Take Quiz</button>
    </form>

    <a href="/quiz/my-quizzes"><button>My Quizzes</button></a>
</div>

<!-- User Authentication Section -->
<div>
    @if(Auth::check())
        <p>Hello, {{ Auth::user()->name }}!</p>
        <form action="/logout" method="POST" style="display:inline;">
            @csrf
            <button type="submit">Logout</button>
        </form>
    @else
        <a href="/login"><button>Login</button></a>
    @endif
</div>

<script>
    function updateFormAction() {
        const quizId = document.getElementById('quiz_id').value;
        const form = document.getElementById('takeQuizForm');
        if (quizId) {
            form.action = `/quiz/${quizId}/take`;
        }
    }
</script>
