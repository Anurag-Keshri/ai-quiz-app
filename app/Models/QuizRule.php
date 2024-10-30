<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizRule extends Model
{
    protected $fillable = [
        'quiz_id',
        'time_limit',
        'show_score',
        'shuffle_options',
        'shuffle_questions',
        'show_correct_answer',
        'start_date',
        'end_date',
    ];

    protected $attributes = [
        'time_limit' => null,
        'show_score' => true,
        'shuffle_options' => true,
        'shuffle_questions' => true,
        'show_correct_answer' => true,
        'start_date' => null,
        'end_date' => null,
    ];

    protected $casts = [
        'show_score' => 'boolean',
        'shuffle_options' => 'boolean',
        'shuffle_questions' => 'boolean',
        'show_correct_answer' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    /**
     * Get the quiz that owns the rules.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }
}
