<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuizAnswer extends Model
{
    // Specify the table if it doesn't follow Laravel's naming conventions
    protected $table = 'quiz_answers';

    // Define the fillable attributes
    protected $fillable = [
        'quiz_attempt_id',
        'question_id',
        'selected_answer',
        'is_correct',
    ];

    // Define relationships

    /**
     * Get the quiz attempt that owns the quiz answer.
     */
    public function quizAttempt()
    {
        return $this->belongsTo(QuizAttempt::class);
    }

    /**
     * Get the question that this answer belongs to.
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }
}
