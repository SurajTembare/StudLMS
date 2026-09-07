<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'pass_percentage',
        'status',
    ];

    // Quiz belongs to one Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    // Quiz has many Questions
    public function questions()
    {
        return $this->hasMany(QuizQuestion::class)
            ->orderBy('question_order');
    }

    // Quiz has many Student Attempts
    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }
}