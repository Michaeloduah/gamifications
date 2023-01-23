<?php

use App\Http\Controllers\CourseController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MessageController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [UserController::class, 'index'])->name('homepage');
Route::get('/about_us', [UserController::class, 'about'])->name('about_us');
Route::get('/contact_us', [UserController::class, 'contact'])->name('contact_us');

Route::middleware(['guest'])->group(function () {

    Route::get('/login', [UserController::class, 'login'])->name('login');
    Route::post('/login', [UserController::class, 'loginUser']);

    Route::get('/register', [UserController::class, 'register'])->name('register');
    Route::post('/register', [UserController::class, 'handleRegister']);

});

Route::middleware('auth')->group(function () {
    // Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
    // Route::get('/course', [DashboardController::class, 'course'])->name('course');
    // Route::get('/leaderboard', [DashboardController::class, 'leaderboard'])->name('leaderboard');
    // Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');

    // Route::get('/courses', [DashboardController::class, 'courses'])->name('courses');
    // Route::get('/courses/{id}/questions', [DashboardController::class, 'questions'])->name('questions');
    // Route::get('/createquestion', [DashboardController::class, 'createQuestion'])->name('createquestion');
    // Route::get('/questions', [QuestionController::class, 'create'])->name('questions');

    Route::get('logout', [DashboardController::class, 'logOut'])->name('logout');



    Route::name('home.')->prefix('home')->group(function () {
        Route::get('', [DashboardController::class, 'dashboard'])->name('dashboard');
        Route::get('course', [DashboardController::class, 'course'])->name('course');
        Route::get('leaderboard', [DashboardController::class, 'leaderboard'])->name('leaderboard');

        Route::get('profile', [DashboardController::class, 'profile'])->name('profile');
        Route::get('test', [DashboardController::class, 'test'])->name('test');
        Route::get('taketest/{id}', [DashboardController::class, 'takeTest'])->name('takeTest');
        Route::post('taketest/{id}', [DashboardController::class, 'submitTest'])->name('submitTest');

        Route::get('congrats/{id}', [DashboardController::class, 'finishTest'])->name('finishTest');
        Route::get('results/{id}', [DashboardController::class, 'results'])->name('results');


        Route::get('editprofile', [DashboardController::class, 'editProfile'])->name('editprofile');
        Route::post('editprofile/{id}', [DashboardController::class, 'saveProfile'])->name('saveprofile');
        // Route::get('/editprofile/{id}', [DashboardController::class, 'editProfile'])->name('profile.edit');
        // Route::post('/editprofile/{id}', [DashboardController::class, 'saveProfile'])->name('profile.update');

        Route::name('courses.')->prefix('courses')->group(function(){
            Route::get('week1', [CourseController::class, 'week1'])->name('week1');
            Route::get('week2', [CourseController::class, 'week2'])->name('week2');
            Route::get('week3', [CourseController::class, 'week3'])->name('week3');
            Route::get('week4', [CourseController::class, 'week4'])->name('week4');
            Route::get('week5', [CourseController::class, 'week5'])->name('week5');
            Route::get('week6', [CourseController::class, 'week6'])->name('week6');
            Route::get('week7', [CourseController::class, 'week7'])->name('week7');
            Route::get('week8', [CourseController::class, 'week8'])->name('week8');
            Route::get('week9', [CourseController::class, 'week9'])->name('week9');
            Route::get('week10', [CourseController::class, 'week10'])->name('week10');
            Route::get('week11', [CourseController::class, 'week11'])->name('week11');
            Route::get('week12', [CourseController::class, 'week12'])->name('week12');
        });
    });

    // Route::get('/message', [MessageController::class, 'index'])->name('message');
    Route::post('/message', [MessageController::class, 'store'])->name('message');

    Route::name('admin.')->prefix('admin')->group(function () {

        Route::name('courses.')->prefix('courses')->group(function () {
            Route::get('', [CourseController::class, 'index'])->name('index');
            Route::get('create', [CourseController::class, 'create'])->name('create');
            Route::post('create', [CourseController::class, 'store'])->name('store');

            Route::prefix('questions')->name('questions.')->group(function () {
                Route::get('addquestion/{id}', [QuestionController::class, 'addquestion'])->name('addquestion');
                Route::post('addquestions/{id}', [QuestionController::class, 'store'])->name('store');
                Route::get('{id}', [QuestionController::class, 'index'])->name('index');
                Route::get('edit/{id}', [QuestionController::class, 'edit'])->name('edit');
            });
        });

        Route::name('users.')->prefix('users')->group(function () {
            Route::get('', [DashboardController::class, 'users'])->name('index');

            // Route::prefix('questions')->name('questions.')->group(function(){
            //     Route::get('{id}', [QuestionController::class, 'index'])->name('index');
            // });
        });

        Route::name('message.')->prefix('message')->group(function () {
            Route::get('', [MessageController::class, 'show'])->name('index');
            Route::get('{id}', [MessageController::class, 'destroy'])->name('deleteMessage');
        });

    });
});
