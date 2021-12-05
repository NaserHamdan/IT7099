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

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');
//Route::get('/Invigilators', [App\Http\Controllers\InvigilatorsController::class, 'invigilators'])->name('Invigilators')->middleware('auth');
Route::get('/Invigilators', [App\Http\Controllers\InvigilatorsController::class, 'loadtutors'])->name('Invigilators')->middleware('auth');
Route::get('/Labs', [App\Http\Controllers\LabsController::class, 'loadlabs'])->name('Labs')->middleware('auth');
Route::get('/Courses', [App\Http\Controllers\CourseController::class, 'loadcourses'])->name('courses')->middleware('auth');
Route::get('/LinkTutors', [App\Http\Controllers\LinkingController::class, 'linkCoursesTutors'])->name('LinkTutors')->middleware('auth');
Route::get('/test', [App\Http\Controllers\HomeController::class, 'index'])->name('test');
