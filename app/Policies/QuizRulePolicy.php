<?php

namespace App\Policies;

use App\Models\QuizRule;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuizRulePolicy
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
    public function view(User $user, QuizRule $quizRule): bool
    {
        return $user->id === $quizRule->quiz->user_id; // only the owner can view the quiz rules
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // anyone can create a quiz rule
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, QuizRule $quizRule): bool
    {
        return $user->id === $quizRule->quiz->user_id; // only the owner can update the quiz rules
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, QuizRule $quizRule): bool
    {
        return $user->id === $quizRule->quiz->user_id; // only the owner can delete the quiz rules
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, QuizRule $quizRule): bool
    {
        return $user->id === $quizRule->quiz->user_id; // only the owner can restore the quiz rules
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, QuizRule $quizRule): bool
    {
        return $user->id === $quizRule->quiz->user_id; // only the owner can permanently delete the quiz rules
    }
}
