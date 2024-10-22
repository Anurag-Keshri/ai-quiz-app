
    <div class="container">
        <h1>Quiz Details</h1>
        
        <div>
            <strong>User:</strong> {{ $quiz->user->name }}<br>
            <strong>Title:</strong> {{ $quiz->title }}<br>
            <strong>Description:</strong> {{ $quiz->description ?? 'N/A' }}<br>
            <strong>Number of Questions:</strong> {{ $quiz->number_of_questions }}<br>
            <strong>Number of Options:</strong> {{ $quiz->number_of_options }}<br>
            <strong>Created At:</strong> {{ $quiz->created_at->format('d-m-Y H:i:s') }}<br>
            <strong>Updated At:</strong> {{ $quiz->updated_at->format('d-m-Y H:i:s') }}<br>
        </div>
        
    </div>
