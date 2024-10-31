<?php

namespace App\Policies;

use App\Models\Attempt;
use App\Models\User;
use App\Models\Quiz;
use Illuminate\Auth\Access\Response;

class AttemptPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Attempt $attempt, Quiz $quiz): bool
    {
        return $user->id === $quiz->user_id || $user->id === $attempt->user_id;
    }

	/**
	 * Determine whether the user can view the model for a quiz.
	 */
	public function viewForQuiz(User $user, Quiz $quiz): bool
	{
		return $user->id === $quiz->user_id;
	}

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Attempt $attempt): bool
    {
        return $user->id === $attempt->user_id;
    }


	/**
	 * Determine whether the user can submit the model.
	 */
	public function submit(User $user, Attempt $attempt): bool
	{
		return $user->id === $attempt->user_id;
	}

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Attempt $attempt): bool
    {
        return $user->id === $attempt->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Attempt $attempt): bool
    {
        return $user->id === $attempt->user_id;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Attempt $attempt): bool
    {
        return $user->id === $attempt->user_id;
    }
}
