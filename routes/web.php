<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\EnrollmentManagementController;
use App\Http\Controllers\Admin\LectureController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\QuizController;
use App\Http\Controllers\Admin\QuizQuestionController;
use App\Http\Controllers\Admin\CertificateController as AdminCertificateController;
use App\Http\Controllers\QuizAttemptController;
use App\Http\Controllers\CertificateController;
use App\Http\Controllers\FrontendController;
use App\Http\Controllers\EnrollmentController;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [FrontendController::class, 'index'])->name('home');
Route::get('/courses', [FrontendController::class, 'courses'])->name('courses');
Route::get('/course/{id}', [FrontendController::class, 'courseDetails'])->name('course.details');

//verify certificate
Route::get('/verify-certificate', [CertificateController::class, 'verifyForm'])->name('certificate.verify.form');
Route::post('/verify-certificate', [CertificateController::class, 'verify'])->name('certificate.verify');




Route::middleware('auth')->group(function () {

    // Enroll in Course using Course ID
    Route::post('/course/enroll/{id}', [EnrollmentController::class, 'enroll'])->name('course.enroll');
    // My Learning Page
    Route::get('/my-learning',  [EnrollmentController::class, 'myLearning'])->name('my.learning');
    // Learning Page
    Route::get('/learn/{courseId}', [EnrollmentController::class, 'learn'])->name('course.learn');
    // Open a particular lecture using lecture ID
    Route::get('/learn/{courseId}/lecture/{lectureId}', [EnrollmentController::class, 'learn'])->name('course.learn.lecture');
    Route::post('/learn/{courseId}/lecture/{lectureId}/complete', [EnrollmentController::class, 'completeLecture'])->name('lecture.complete');

    // Start Quiz
    Route::get('/course/{courseId}/quiz/{quizId}', [QuizAttemptController::class, 'start'])->name('student.quiz.start');
    // Submit Quiz   
    Route::post('/course/{courseId}/quiz/{quizId}/submit', [QuizAttemptController::class, 'submit'])->name('student.quiz.submit');
    // Quiz Result

    Route::get('/course/{courseId}/quiz/{quizId}/result/{attemptId}', [QuizAttemptController::class, 'result'])->name('student.quiz.result');
    Route::get('/course/{courseId}/quiz/{quizId}/history', [QuizAttemptController::class, 'history'])->name('student.quiz.history');

    // Certificate Routes
    Route::get('/my-certificates', [CertificateController::class, 'index'])->name('student.certificates.index');
    Route::get('/certificate/{certificateId}', [CertificateController::class, 'show'])->name('student.certificate.show');
    Route::get('/certificate/{certificateId}/download', [CertificateController::class, 'download'])->name('student.certificate.download');
});





Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Student Routes
    Route::get('/students', [StudentController::class, 'index'])->name('students.index');
    Route::get('/students/{id}', [StudentController::class, 'show']) ->name('students.show');
   

    // Enrollment Routes
    Route::get('/enrollments', [EnrollmentManagementController::class, 'index'])->name('enrollments.index');

    // Category Routes
    Route::get('/categories', [CategoryController::class, 'index'])
        ->name('categories.index');

    Route::get('/categories/create', [CategoryController::class, 'create'])
        ->name('categories.create');

    Route::post('/categories/store', [CategoryController::class, 'store'])
        ->name('categories.store');

    Route::get('/categories/edit/{id}', [CategoryController::class, 'edit'])
        ->name('categories.edit');

    Route::put('/categories/update/{id}', [CategoryController::class, 'update'])
        ->name('categories.update');

    Route::delete('/categories/delete/{id}', [CategoryController::class, 'destroy'])
        ->name('categories.destroy');

    // Course Routes
    Route::get('/courses', [CourseController::class, 'index'])
        ->name('courses.index');

    Route::get('/courses/create', [CourseController::class, 'create'])
        ->name('courses.create');

    Route::post('/courses/store', [CourseController::class, 'store'])
        ->name('courses.store');

    Route::get('/courses/edit/{id}', [CourseController::class, 'edit'])
        ->name('courses.edit');

    Route::put('/courses/update/{id}', [CourseController::class, 'update'])
        ->name('courses.update');

    Route::delete('/courses/delete/{id}', [CourseController::class, 'destroy'])
        ->name('courses.destroy');

    Route::post('/courses/{id}/toggle-content-status', [CourseController::class, 'toggleContentStatus'])->name('courses.toggle-content-status');




    //lecture Routes

    // Lecture List
    Route::get('/lectures', [LectureController::class, 'index'])
        ->name('lectures.index');

    // Add Lecture Page
    Route::get('/lectures/create', [LectureController::class, 'create'])
        ->name('lectures.create');

    // Store Lecture
    Route::post('/lectures/store', [LectureController::class, 'store'])
        ->name('lectures.store');

    // Edit Lecture using ID
    Route::get('/lectures/edit/{id}', [LectureController::class, 'edit'])
        ->name('lectures.edit');

    // Update Lecture using ID
    Route::put('/lectures/update/{id}', [LectureController::class, 'update'])
        ->name('lectures.update');

    // Delete Lecture using ID
    Route::delete('/lectures/delete/{id}', [LectureController::class, 'destroy'])
        ->name('lectures.destroy');

    // Quiz Routes  
    Route::resource('quizzes', QuizController::class)->except(['show'])->names('quizzes');

    //certificate Routes
    

    Route::get('/certificates', [AdminCertificateController::class, 'index'])
        ->name('certificates.index');

    Route::get('/certificates/{id}', [AdminCertificateController::class, 'show'])
        ->name('certificates.show');

    Route::get('/certificates/{id}/download', [AdminCertificateController::class, 'download'])
        ->name('certificates.download');

    Route::delete('/certificates/{id}', [AdminCertificateController::class, 'destroy'])
        ->name('certificates.destroy');

    Route::prefix('quizzes/{quizId}/questions')
        ->group(function () {

            Route::get('/', [QuizQuestionController::class, 'index'])
                ->name('quiz.questions.index');

            Route::get('/create', [QuizQuestionController::class, 'create'])
                ->name('quiz.questions.create');

            Route::post('/', [QuizQuestionController::class, 'store'])
                ->name('quiz.questions.store');

            Route::get('/{questionId}/edit',  [QuizQuestionController::class, 'edit'])->name('quiz.questions.edit');
            Route::put('/{questionId}', [QuizQuestionController::class, 'update'])->name('quiz.questions.update');
            Route::delete('/{questionId}', [QuizQuestionController::class, 'destroy'])->name('quiz.questions.destroy');
        });
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    return redirect('/');
})->middleware('auth')->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
