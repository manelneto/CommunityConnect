<?php

use App\Http\Controllers\AnswerCommentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\QuestionCommentController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Home
Route::redirect('/', '/communities');

// Authentication
Route::controller(RegisterController::class)->group(function () {
    Route::get('/register', 'showRegisterForm')->name('register');
    Route::post('/register', 'register');
});
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'showLoginForm')->name('login');
    Route::post('/login', 'authenticate');
    Route::get('/logout', 'logout')->name('logout');
});

// Profile
Route::controller(UserController::class)->group(function () {
    Route::post('/users', 'store');
    Route::get('/users/{id}', 'show')->name('profile');
    Route::get('/users/{id}/edit', 'edit')->name('edit-user');
    Route::post('/users/{id}', 'update');
    Route::post('/users/{id}/delete', 'destroy');
});

// Questions
Route::controller(QuestionController::class)->group(function () {
    Route::get('/questions', 'index')->name('questions');
    Route::get('/questions/create', 'create')->name('create-question');
    Route::post('/questions', 'store');
    Route::get('/questions/{id}', 'show')->name('question');
    Route::get('/questions/{id}/edit', 'edit')->name('edit-question');
    Route::post('/questions/{id}', 'update');
    Route::post('/questions/{id}/delete', 'destroy');
});

// Question Comments
Route::controller(QuestionCommentController::class)->group(function() {
    Route::post('/question-comments', 'store');
    Route::post('/question-comments/{id}', 'update');
    Route::post('/question-comments/{id}/delete', 'destroy');
});

// Answers
Route::controller(AnswerController::class)->group(function () {
    Route::get('/answers/{id}/edit', 'edit')->name('edit-answer');
    Route::post('/answers', 'store');
    Route::post('/answers/{id}', 'update');
    Route::post('/answers/{id}/delete', 'destroy');
    Route::post('/answers/{id}/correct', 'markCorrect');
    Route::post('/answers/{id}/incorrect', 'markIncorrect');
});

// Answer Comments
Route::controller(AnswerCommentController::class)->group(function() {
    Route::post('/answer-comments', 'store');
    Route::post('/answer-comments/{id}', 'update');
    Route::post('/answer-comments/{id}/delete', 'destroy');
});

// Admin
Route::get('/admin', [UserController::class, 'index'])->name('admin');
Route::post('/admin/block', [UserController::class, 'block_user'])->name('block-user');
Route::post('/admin/unblock', [UserController::class, 'unblock_user'])->name('unblock-user');

//Communities
Route::get('/communities', [CommunityController::class, 'index'])->name('communities');
Route::get('/communities/{id}', [QuestionController::class, 'communityIndex'])->name('community');
Route::get('/feed', [QuestionController::class, 'personalIndex'])->name('feed');

// API
Route::get('api/questions', [QuestionController::class, 'search']);
Route::get('api/users', [UserController::class, 'search']);
Route::post('api/communities/follow', [CommunityController::class, 'follow']);
Route::post('api/communities/unfollow', [CommunityController::class, 'unfollow']);
Route::post('api/questions/{id}/follow', [QuestionController::class, 'follow']);
Route::post('api/questions/{id}/unfollow', [QuestionController::class, 'unfollow']);

// Static info pages
Route::view('/about-contact-us', 'pages.about-contact-us')->name('about-contact-us');
Route::view('/main-features', 'pages.main-features')->name('main-features');