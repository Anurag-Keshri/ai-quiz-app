<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quiz_rules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('quiz_id')
                ->constrained('quizzes')
                ->onDelete('cascade');
            $table->integer('time_limit')->nullable(); 
            $table->boolean('show_score')->default(true);
            $table->boolean('shuffle_options')->default(false);
            $table->boolean('shuffle_questions')->default(false);
            $table->boolean('show_correct_answer')->default(false);
            $table->timestamp('start_date')->nullable();
            $table->timestamp('end_date')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quiz_rules');
    }
};