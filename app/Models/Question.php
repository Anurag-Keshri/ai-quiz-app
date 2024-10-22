<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Question extends Model
{
    use HasFactory;

    protected $fillable = [
		'quiz_id', 
		'question_text',
		'options',
		'correct_answer'
	];

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
