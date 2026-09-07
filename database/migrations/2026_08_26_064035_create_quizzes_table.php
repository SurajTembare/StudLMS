<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
           $table->id();

        $table->foreignId('course_id')
            ->constrained()
            ->cascadeOnDelete();

        $table->string('title');

        $table->text('description')->nullable();

        // विद्यार्थी पास होण्यासाठी आवश्यक percentage
        $table->unsignedInteger('pass_percentage')->default(40);

        // Quiz active आहे का?
        $table->enum('status', ['active', 'inactive'])
            ->default('active');

        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};
