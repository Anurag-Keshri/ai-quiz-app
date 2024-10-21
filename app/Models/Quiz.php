<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'user_id'];

    // Define a relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Define a relationship with the Question model
    public function questions()
    {
        return $this->hasMany(Question::class);
    }

    // Define a relationship with the QuizAttempt model
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}
