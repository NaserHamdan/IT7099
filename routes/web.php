<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
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
//     return view('index');
// });

// Route::get('/', function () {

//     return view('index');
// })->name('home')->middleware('auth');

// Auth::routes();
Auth::routes([
    'reset' => false,
    'verify' => false,
    'register' => false,
]);

Route::get('/test', [App\Http\Controllers\HomeController::class, 'index'])->name('test');
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
//tutors routes
Route::get('/Invigilators', [App\Http\Controllers\InvigilatorsController::class, 'invigilators'])->name('Invigilators')->middleware('auth');
//schedule routes
Route::get('/Schedule', [App\Http\Controllers\ScheduleController::class, 'schedule'])->name('Schedule')->middleware('auth');
//labs routes
Route::get('/Labs', [App\Http\Controllers\LabsController::class, 'labs'])->name('Labs')->middleware('auth');
//courses routes
Route::get('/Courses', [App\Http\Controllers\CourseController::class, 'Courses'])->name('Courses')->middleware('auth');
Route::get('/EditCourses', [App\Http\Controllers\CourseController::class, 'EditCourses'])->name('EditCourses')->middleware('auth');
//load database routes
Route::get('/LoadTutors', [App\Http\Controllers\InvigilatorsController::class, 'loadtutors'])->name('LoadTutors')->middleware('auth');
Route::get('/LoadLabs', [App\Http\Controllers\LabsController::class, 'loadlabs'])->name('LoadLabs')->middleware('auth');
Route::get('/LoadCourses', [App\Http\Controllers\CourseController::class, 'loadcourses'])->name('LoadCourses')->middleware('auth');
Route::get('/LinkTutors', [App\Http\Controllers\LinkingController::class, 'linkCoursesTutors'])->name('LinkTutors')->middleware('auth');

