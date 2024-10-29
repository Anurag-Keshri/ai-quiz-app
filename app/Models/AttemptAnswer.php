<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttemptAnswer extends Model
{
    protected $fillable = [
        'attempt_id',
        'option_id',
    ];

    /**
     * Get the attempt that owns the answer.
     */
    public function attempt(): BelongsTo
    {
        return $this->belongsTo(Attempt::class);
    }


    /**
     * Get the selected option.
     */
    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }

    /**
     * Determine if this answer is correct.
     */
    public function isCorrect(): bool
    {
        return $this->option->is_correct;
    }
}
