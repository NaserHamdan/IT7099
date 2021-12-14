<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\InvigilatorsController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\LabsController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LinkingController;
use App\Http\Controllers\ApiController;
use App\Http\Controllers\SettingController;

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

Route::get('/test', [HomeController::class, 'index'])->name('test');
Route::get('/', [HomeController::class, 'index'])->name('home')->middleware('auth');
//tutors routes
Route::get('/Invigilators', [InvigilatorsController::class, 'invigilators'])->name('Invigilators')->middleware('auth');
//schedule routes
Route::get('/Schedule', [ScheduleController::class, 'schedule'])->name('Schedule')->middleware('auth');
//labs routes
Route::get('/Labs', [LabsController::class, 'labs'])->name('Labs')->middleware('auth');
//courses routes
Route::get('/Courses', [CourseController::class, 'Courses'])->name('Courses')->middleware('auth');
Route::get('/EditCourses', [CourseController::class, 'EditCourses'])->name('EditCourses')->middleware('auth');
//load database routes
Route::get('/LoadTutors', [InvigilatorsController::class, 'loadtutors'])->name('LoadTutors')->middleware('auth');
Route::get('/LoadLabs', [LabsController::class, 'loadlabs'])->name('LoadLabs')->middleware('auth');
Route::get('/LoadCourses', [CourseController::class, 'loadcourses'])->name('LoadCourses')->middleware('auth');
Route::get('/LinkTutors', [LinkingController::class, 'linkCoursesTutors'])->name('LinkTutors')->middleware('auth');
//api
Route::post('/addCourse', [ApiController::class, 'addCourse'])->name('addCourse')->middleware('auth');
Route::post('/deleteCourse', [ApiController::class, 'deleteCourse'])->name('deleteCourse')->middleware('auth');
Route::get('/fetchCourseData', [ApiController::class, 'fetchCourseData'])->name('fetchCourseData')->middleware('auth');
Route::post('/editCourse', [ApiController::class, 'editCourse'])->name('editCourse')->middleware('auth');
//
Route::post('/addTutor', [ApiController::class, 'addTutor'])->name('addTutor')->middleware('auth');
Route::post('/deleteTutor', [ApiController::class, 'deleteTutor'])->name('deleteTutor')->middleware('auth');
Route::get('/fetchTutorData', [ApiController::class, 'fetchTutorData'])->name('fetchTutorData')->middleware('auth');
Route::post('/editTutor', [ApiController::class, 'editTutor'])->name('editTutor')->middleware('auth');
//
Route::post('/addLab', [ApiController::class, 'addLab'])->name('addLab')->middleware('auth');
Route::post('/deleteLab', [ApiController::class, 'deleteLab'])->name('deleteLab')->middleware('auth');
Route::get('/fetchLabData', [ApiController::class, 'fetchLabData'])->name('fetchLabData')->middleware('auth');
Route::post('/editLab', [ApiController::class, 'editLab'])->name('editLab')->middleware('auth');

////
Route::get('/updateInvigilators', [ApiController::class, 'updateInvigilators'])->name('updateInvigilators')->middleware('auth');
//
Route::post('/addExam', [ApiController::class, 'addExam'])->name('addExam')->middleware('auth');
Route::post('/deleteExam', [ApiController::class, 'deleteExam'])->name('deleteExam')->middleware('auth');
//
Route::post('/updateSettings', [SettingController::class, 'updateSettings'])->name('updateSettings')->middleware('auth');
