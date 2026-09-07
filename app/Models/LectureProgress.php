<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LectureProgress extends Model
{
    protected $table = 'lecture_progress';

    protected $fillable = [
        'user_id',
        'course_id',
        'lecture_id',
        'is_completed',
        'completed_at',
    ];

    protected $casts = [
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function lecture()
    {
        return $this->belongsTo(Lecture::class);
    }
}