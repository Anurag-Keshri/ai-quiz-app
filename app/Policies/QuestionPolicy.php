<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuestionPolicy
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
    public function view(User $user, Question $question): bool
    {
        return $user->id === $question->quiz->user_id; // only the owner can view the question
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Quiz $quiz): bool
    {
        return $user->id === $quiz->user_id; // only the owner can create a question
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Question $question): bool
    {
        return $user->id === $question->quiz->user_id; // only the owner can update the question
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Question $question): bool
    {
        return $user->id === $question->quiz->user_id; // only the owner can delete the question
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Question $question): bool
    {
        return $user->id === $question->quiz->user_id; // only the owner can restore the question
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Question $question): bool
    {
        return $user->id === $question->quiz->user_id; // only the owner can force delete the question
    }
}
