<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Quiz extends Model
{
    protected $fillable = [
        'title',
        'description',
        'user_id',
    ];

    /**
     * Get the user that created the quiz.
     */
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the rules for the quiz.
     */
    public function rules(): HasOne
    {
        return $this->hasOne(QuizRule::class);
    }

    /**
     * Get the questions for the quiz.
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Get the attempts for the quiz.
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(Attempt::class);
    }
}
