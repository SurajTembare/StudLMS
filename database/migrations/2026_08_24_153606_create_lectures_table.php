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
        Schema::create('lectures', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('course_id');

            $table->string('title');

            $table->text('description')->nullable();

            // Video URL (YouTube, Vimeo, etc.)
            $table->string('video_url')->nullable();

            // Recorded video uploaded from device
            $table->string('video')->nullable();

            // PDF or notes
            $table->string('document')->nullable();

            $table->integer('lecture_order')->default(1);

            $table->enum('status', ['active', 'inactive'])
                ->default('active');

            $table->timestamps();

            $table->foreign('course_id')
                ->references('id')
                ->on('courses')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lectures');
    }
};
