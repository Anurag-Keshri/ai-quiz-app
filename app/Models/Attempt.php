<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attempt extends Model
{
    protected $fillable = [
        'user_id',
        'quiz_id',
		'score',
        'completed_at',
    ];

    protected $casts = [
		'score' => 'integer',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the user that owns the attempt.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the quiz that owns the attempt.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the answers for the attempt.
     */
    public function answers(): HasMany
    {
        return $this->hasMany(AttemptAnswer::class);
    }

	/**
	 * Calculate the score for the attempt.
	 */
	public function getScoreAttribute(): int
	{
		if ($this->attributes['score']) {
			return $this->attributes['score'];
		}

		$this->attributes['score'] = $this->answers
			->filter(function ($answer) {
				return $answer->isCorrect();
			})
			->count();
		$this->save();

		return $this->attributes['score'];
	}
}
