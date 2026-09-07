<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lecture extends Model
{
    protected $fillable = [
        'course_id',
        'title',
        'description',
        'video_url',
        'video',
        'document',
        'lecture_order',
        'status',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}