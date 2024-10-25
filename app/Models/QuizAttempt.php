<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'quiz_id', 'score', 'completed', 'completed_at', 'started_at'];

    protected $casts = [
        'started_at' => 'datetime', // Ensure started_at is treated as a Carbon instance
        'completed_at' => 'datetime',
    ];
	
    // Define a relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define a relationship with the Quiz model
    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    // Define a relationship with the QuizAnswer model
    public function quizAnswers()
    {
        return $this->hasMany(QuizAnswer::class);
    }
}
