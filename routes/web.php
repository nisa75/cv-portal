<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\CandidateProfileController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\ExperienceController;
use App\Http\Controllers\SkillController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\CvController;
use App\Http\Controllers\ApplicationController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\AiController;
// ==================================================
// ANA SAYFA
// ==================================================

Route::get('/', function () {
    return view('welcome');
});


// ==================================================
// REGISTER
// ==================================================

Route::get('/register', [RegisterController::class, 'showRegistrationForm']);

Route::post('/register', [RegisterController::class, 'register']);


// ==================================================
// LOGIN
// ==================================================

Route::get('/login', [LoginController::class, 'showLoginForm'])
    ->name('login');

Route::post('/login', [LoginController::class, 'login']);


// ==================================================
// DASHBOARDS
// ==================================================

Route::get('/candidate/dashboard', function () {
    return view('candidate-dashboard');
})->middleware(['auth', 'role:candidate']);


Route::get('/employer/dashboard', function () {
    return view('employer-dashboard');
})->middleware(['auth', 'role:employer']);


Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])
    ->middleware(['auth', 'role:admin']);


// ==================================================
// CANDIDATE PROFILE
// ==================================================

Route::get('/candidate/profile', [CandidateProfileController::class, 'show'])
    ->middleware(['auth', 'role:candidate']);

Route::post('/candidate/profile', [CandidateProfileController::class, 'store'])
    ->middleware(['auth', 'role:candidate']);

Route::post('/candidate/ai/generate-about', [AiController::class, 'generateAbout'])
    ->middleware(['auth', 'role:candidate']);
// ==================================================
// EDUCATION
// ==================================================

Route::get('/candidate/educations', [EducationController::class, 'index'])
    ->middleware(['auth', 'role:candidate']);

Route::get('/candidate/educations/create', [EducationController::class, 'create'])
    ->middleware(['auth', 'role:candidate']);

Route::post('/candidate/educations', [EducationController::class, 'store'])
    ->middleware(['auth', 'role:candidate']);

Route::get('/candidate/educations/{education}/edit', [EducationController::class, 'edit'])
    ->middleware(['auth', 'role:candidate']);

Route::put('/candidate/educations/{education}', [EducationController::class, 'update'])
    ->middleware(['auth', 'role:candidate']);

Route::delete('/candidate/educations/{education}', [EducationController::class, 'destroy'])
    ->middleware(['auth', 'role:candidate']);


// ==================================================
// EXPERIENCE
// ==================================================

Route::get('/candidate/experiences', [ExperienceController::class, 'index'])
    ->middleware(['auth', 'role:candidate']);

Route::get('/candidate/experiences/create', [ExperienceController::class, 'create'])
    ->middleware(['auth', 'role:candidate']);

Route::post('/candidate/experiences', [ExperienceController::class, 'store'])
    ->middleware(['auth', 'role:candidate']);

Route::get('/candidate/experiences/{experience}/edit', [ExperienceController::class, 'edit'])
    ->middleware(['auth', 'role:candidate']);

Route::put('/candidate/experiences/{experience}', [ExperienceController::class, 'update'])
    ->middleware(['auth', 'role:candidate']);

Route::delete('/candidate/experiences/{experience}', [ExperienceController::class, 'destroy'])
    ->middleware(['auth', 'role:candidate']);


// ==================================================
// SKILLS
// ==================================================

Route::get('/candidate/skills', [SkillController::class, 'index'])
    ->middleware(['auth', 'role:candidate']);

Route::post('/candidate/skills', [SkillController::class, 'store'])
    ->middleware(['auth', 'role:candidate']);

Route::delete('/candidate/skills/{skill}', [SkillController::class, 'destroy'])
    ->middleware(['auth', 'role:candidate']);


// ==================================================
// CV
// ==================================================

Route::get('/candidate/cvs', [CvController::class, 'index'])
    ->middleware(['auth', 'role:candidate']);

Route::get('/candidate/cvs/create', [CvController::class, 'create'])
    ->middleware(['auth', 'role:candidate']);

Route::post('/candidate/cvs', [CvController::class, 'store'])
    ->middleware(['auth', 'role:candidate']);

Route::get('/candidate/cvs/{cv}/edit', [CvController::class, 'edit'])
    ->middleware(['auth', 'role:candidate']);

Route::put('/candidate/cvs/{cv}', [CvController::class, 'update'])
    ->middleware(['auth', 'role:candidate']);

Route::get('/candidate/cvs/{cv}/pdf', [CvController::class, 'pdf'])
    ->middleware(['auth', 'role:candidate']);

Route::put('/candidate/cvs/{cv}/visibility', [CvController::class, 'togglePublic'])
    ->middleware(['auth', 'role:candidate']);

Route::get('/candidate/cvs/{cv}', [CvController::class, 'show'])
    ->middleware(['auth', 'role:candidate']);

Route::delete('/candidate/cvs/{id}', [CvController::class, 'destroy'])
    ->middleware(['auth', 'role:candidate']);


// ==================================================
// PUBLIC CV
// ==================================================

Route::get('/cv/{token}', [CvController::class, 'publicShow']);


// ==================================================
// CANDIDATE JOBS
// ==================================================

Route::get('/candidate/jobs', [JobController::class, 'index'])
    ->middleware(['auth', 'role:candidate']);

Route::get('/candidate/jobs/{job}', [JobController::class, 'show'])
    ->middleware(['auth', 'role:candidate']);


// ==================================================
// APPLICATIONS - CANDIDATE
// ==================================================

Route::get('/candidate/jobs/{job}/apply', [ApplicationController::class, 'create'])
    ->middleware(['auth', 'role:candidate']);

Route::post('/candidate/jobs/{job}/apply', [ApplicationController::class, 'store'])
    ->middleware(['auth', 'role:candidate']);

Route::get('/candidate/applications', [ApplicationController::class, 'index'])
    ->middleware(['auth', 'role:candidate']);


// ==================================================
// FAVORITES
// ==================================================

Route::get('/candidate/favorites', [FavoriteController::class, 'index'])
    ->middleware(['auth', 'role:candidate']);

Route::post('/candidate/jobs/{job}/favorite', [FavoriteController::class, 'store'])
    ->middleware(['auth', 'role:candidate']);

Route::delete('/candidate/jobs/{job}/favorite', [FavoriteController::class, 'destroy'])
    ->middleware(['auth', 'role:candidate']);


// ==================================================
// NOTIFICATIONS
// ==================================================

Route::get('/candidate/notifications', [NotificationController::class, 'index'])
    ->middleware(['auth', 'role:candidate']);

Route::get('/candidate/notifications/{notification}/read', [NotificationController::class, 'read'])
    ->middleware(['auth', 'role:candidate']);

Route::get('/employer/notifications', [NotificationController::class, 'index'])
    ->middleware(['auth', 'role:employer']);

Route::get('/employer/notifications/{notification}/read', [NotificationController::class, 'read'])
    ->middleware(['auth', 'role:employer']);


// ==================================================
// EMPLOYER COMPANY
// ==================================================

Route::get('/employer/company', [CompanyController::class, 'show'])
    ->middleware(['auth', 'role:employer']);

Route::post('/employer/company', [CompanyController::class, 'store'])
    ->middleware(['auth', 'role:employer']);


// ==================================================
// EMPLOYER JOBS
// ==================================================

Route::get('/employer/jobs', [JobController::class, 'employerIndex'])
    ->middleware(['auth', 'role:employer']);

Route::get('/employer/jobs/create', [JobController::class, 'create'])
    ->middleware(['auth', 'role:employer']);

Route::post('/employer/jobs', [JobController::class, 'store'])
    ->middleware(['auth', 'role:employer']);

Route::get('/employer/jobs/{job}/edit', [JobController::class, 'edit'])
    ->middleware(['auth', 'role:employer']);

Route::put('/employer/jobs/{job}', [JobController::class, 'update'])
    ->middleware(['auth', 'role:employer']);

Route::delete('/employer/jobs/{job}', [JobController::class, 'destroy'])
    ->middleware(['auth', 'role:employer']);


// ==================================================
// APPLICATIONS - EMPLOYER
// ==================================================

Route::get('/employer/applications', [ApplicationController::class, 'employerIndex'])
    ->middleware(['auth', 'role:employer']);

Route::get('/employer/applications/{application}', [ApplicationController::class, 'employerShow'])
    ->middleware(['auth', 'role:employer']);

Route::put('/employer/applications/{application}/status', [ApplicationController::class, 'updateStatus'])
    ->middleware(['auth', 'role:employer']);


// ==================================================
// MESSAGES
// ==================================================

// Mesajlar listesi
Route::get('/messages', [MessageController::class, 'index'])
    ->middleware('auth');

// Başvuru üzerinden konuşma başlat
Route::get('/applications/{application}/message', [MessageController::class, 'createFromApplication'])
    ->middleware('auth');

// Konuşmayı görüntüle
Route::get('/messages/{conversation}', [MessageController::class, 'show'])
    ->middleware('auth');

// Mesaj gönder
Route::post('/messages/{conversation}', [MessageController::class, 'store'])
    ->middleware('auth');
Route::get('/employer/applications/{application}/interview/create', [InterviewController::class, 'create'])
    ->middleware(['auth', 'role:employer']);

Route::post('/employer/applications/{application}/interview', [InterviewController::class, 'store'])
    ->middleware(['auth', 'role:employer']);

Route::get('/candidate/interviews', [InterviewController::class, 'candidateIndex'])
    ->middleware(['auth', 'role:candidate']);

Route::put('/candidate/interviews/{interview}/respond', [InterviewController::class, 'respond'])
    ->middleware(['auth', 'role:candidate']);

// ==================================================
// ADMIN
// ==================================================

Route::get('/admin/users', [AdminController::class, 'users'])
    ->middleware(['auth', 'role:admin']);

Route::get('/admin/companies', [AdminController::class, 'companies'])
    ->middleware(['auth', 'role:admin']);

Route::get('/admin/jobs', [AdminController::class, 'jobs'])
    ->middleware(['auth', 'role:admin']);

Route::get('/admin/applications', [AdminController::class, 'applications'])
    ->middleware(['auth', 'role:admin']);


// Admin kullanıcı silme
Route::delete('/admin/users/{user}', [AdminController::class, 'deleteUser'])
    ->middleware(['auth', 'role:admin']);

// Admin ilan durumu
Route::put('/admin/jobs/{job}/status', [AdminController::class, 'toggleJobStatus'])
    ->middleware(['auth', 'role:admin']);

// Admin ilan silme
Route::delete('/admin/jobs/{job}', [AdminController::class, 'deleteJob'])
    ->middleware(['auth', 'role:admin']);

// Admin başvuru detay
Route::get('/admin/applications/{application}', [AdminController::class, 'showApplication'])
    ->middleware(['auth', 'role:admin']);


// ==================================================
// LOGOUT
// ==================================================

Route::post('/logout', function () {
    Auth::logout();

    request()->session()->invalidate();
    request()->session()->regenerateToken();

    return redirect('/login');
})->middleware('auth');