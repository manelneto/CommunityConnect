<?php

use App\Http\Controllers\AnswerCommentController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\PasswordController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\AnswerController;
use App\Http\Controllers\CommunityController;
use App\Http\Controllers\MailController;
use App\Http\Controllers\QuestionCommentController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionVoteController;
use App\Http\Controllers\AnswerVoteController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TagController;
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
    Route::get('/register', 'show')->name('register');
    Route::post('/register', 'register');
});
Route::controller(LoginController::class)->group(function () {
    Route::get('/login', 'show')->name('login');
    Route::post('/login', 'login');
    Route::get('/logout', 'logout')->name('logout');
});

// Password
Route::post('/mail', [MailController::class, 'send']);
Route::get('/password/{username}/{token}', [PasswordController::class, 'show'])->name('password');
Route::post('/password', [PasswordController::class, 'update'])->name('update-password');

// Profile
Route::controller(UserController::class)->group(function () {
    Route::post('/users', 'store')->name('users');
    Route::get('/users/{id}', 'show')->where('id', '[0-9]+')->name('profile');
    Route::get('/users/{id}/edit', 'edit')->where('id', '[0-9]+')->name('edit-user');
    Route::post('/users/{id}', 'update')->where('id', '[0-9]+');
    Route::post('/users/{id}/delete', 'destroy')->where('id', '[0-9]+');
});

// Questions
Route::controller(QuestionController::class)->group(function () {
    Route::get('/questions', 'index')->name('questions');
    Route::get('/questions/create', 'create')->name('create-question');
    Route::post('/questions', 'store');
    Route::get('/questions/{id}', 'show')->where('id', '[0-9]+')->name('question');
    Route::get('/questions/{id}/edit', 'edit')->where('id', '[0-9]+')->name('edit-question');
    Route::post('/questions/{id}', 'update')->where('id', '[0-9]+')->name('update-question');
    Route::post('/questions/{id}/delete', 'destroy')->where('id', '[0-9]+')->name('delete-question');
});

// Question Comments
Route::controller(QuestionCommentController::class)->group(function() {
    Route::post('/question-comments', 'store')->name('question-comments');
    Route::post('/question-comments/{id}', 'update')->where('id', '[0-9]+')->name('edit-question-comment');
    Route::post('/question-comments/{id}/delete', 'destroy')->where('id', '[0-9]+')->name('delete-question-comment');
});

// Answers
Route::controller(AnswerController::class)->group(function () {
    Route::get('/answers/{id}/edit', 'edit')->where('id', '[0-9]+')->name('edit-answer');
    Route::post('/answers', 'store')->name('answers');
    Route::post('/answers/{id}', 'update')->where('id', '[0-9]+');
    Route::post('/answers/{id}/delete', 'destroy')->where('id', '[0-9]+')->name('delete-answer');
});

// Answer Comments
Route::controller(AnswerCommentController::class)->group(function() {
    Route::post('/answer-comments', 'store')->name('answer-comments');
    Route::post('/answer-comments/{id}', 'update')->where('id', '[0-9]+')->name('edit-answer-comment');
    Route::post('/answer-comments/{id}/delete', 'destroy')->where('id', '[0-9]+')->name('delete-answer-comment');
});

// Admin
Route::get('/admin', [UserController::class, 'admin'])->name('admin');
Route::post('/admin/block', [UserController::class, 'block'])->name('block');
Route::post('/admin/unblock', [UserController::class, 'unblock'])->name('unblock');
Route::post('/tags', [TagController::class, 'store'])->name('create-tag');
Route::post('/tags/edit', [TagController::class, 'update'])->name('edit-tag');
Route::post('/tags/delete', [TagController::class, 'destroy'])->name('delete-tag');
Route::post('/communities', [CommunityController::class, 'store'])->name('create-community');

// Communities
Route::get('/communities', [CommunityController::class, 'index'])->name('communities');
Route::get('/communities/{id}', [QuestionController::class, 'communityIndex'])->where('id', '[0-9]+')->name('community');
Route::get('/feed', [QuestionController::class, 'personalIndex'])->name('feed');

// API
Route::get('api/questions', [QuestionController::class, 'search']);
Route::get('api/users', [UserController::class, 'search']);
Route::get('api/tags', [TagController::class, 'search']);
Route::post('api/communities/follow', [CommunityController::class, 'follow']);
Route::post('api/communities/unfollow', [CommunityController::class, 'unfollow']);
Route::post('api/questions/follow', [QuestionController::class, 'follow']);
Route::post('api/questions/unfollow', [QuestionController::class, 'unfollow']);
Route::post('api/tags/follow', [TagController::class, 'follow']);
Route::post('api/tags/unfollow', [TagController::class, 'unfollow']);
Route::post('api/notifications/read', [NotificationController::class, 'read']);
Route::post('api/questions/vote', [QuestionVoteController::class, 'vote']);
Route::post('api/questions/unvote', [QuestionVoteController::class, 'unvote']);
Route::post('api/answers/vote', [AnswerVoteController::class, 'vote']);
Route::post('api/answers/unvote', [AnswerVoteController::class, 'unvote']);
Route::post('api/answers/{id}/correct', [AnswerController::class, 'markCorrect']);
Route::post('api/answers/{id}/incorrect', [AnswerController::class, 'markIncorrect']);

// Static Pages
Route::view('/about-contact-us', 'pages.about-contact-us')->name('about-contact-us');
Route::view('/main-features', 'pages.main-features')->name('main-features');
Route::view('/faq', 'pages.faq')->name('faq');
