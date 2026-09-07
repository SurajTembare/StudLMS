<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    protected $fillable = [
        'user_id',
        'course_id',
        'status',
        'completed_at',
    ];

    protected $casts = [
    'completed_at' => 'datetime',
];

    // Enrollment belongs to Student/User
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Enrollment belongs to Course
    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}