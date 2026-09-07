<?php

namespace App\Models;

use App\Models\Category;
use App\Models\Lecture;
use App\Models\Enrollment;
use App\Models\Quiz;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $fillable = [
        'category_id',
        'title',
        'image',
        'description',
        'price',
        'course_type',
        'status',
        'content_finalized',
    ];

    protected $casts = [
        'content_finalized' => 'boolean',
    ];

    // Course belongs to one Category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function lectures()
    {
        return $this->hasMany(Lecture::class);
    }


    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class);
    }
}
