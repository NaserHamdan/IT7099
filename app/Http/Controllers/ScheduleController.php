<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Exam;
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
        $setting = Setting::first();
        // $years = Year::all();
        //dd($exams);
        return view('schedule', ['exams'=>$exams, 'tutors'=>$tutors,'timeslots'=>$timeslots,'courses'=>$courses,'setting'=>$setting]);
    }

}
