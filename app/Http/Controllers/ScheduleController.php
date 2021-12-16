<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
use App\Models\invigilations;
use App\Models\Lab;
use App\Models\Setting;
use App\Models\timeslot;
use App\Models\Tutor;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    //
    public function schedule()
    {
        $exams = Exam::with('course','timeslot','invigilations','labs','tutors')->get();
        $tutors = Tutor::all();
        $timeslots = timeslot::all();
        $courses = Course::all();
        $labs = Lab::all();
        $setting = Setting::first();
        return view('schedule', ['exams'=>$exams, 'tutors'=>$tutors,'timeslots'=>$timeslots,'courses'=>$courses,'labs'=>$labs,'setting'=>$setting]);
    }

    public function getAllExamsLabs(){
        $exams = Exam::with('course','timeslot','invigilations','labs','tutors')->get();
        $labs = Lab::all();
        return response(['exams' => $exams,'labs'=>$labs]);
    }

    public function getAllExamsTutors(){
        $exams = Exam::with('course','timeslot','invigilations','labs','tutors')->get();
        $tutors = Tutor::all();
        return response(['exams' => $exams,'tutors'=>$tutors]);
    }

}
