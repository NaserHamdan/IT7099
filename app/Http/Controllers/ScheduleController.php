<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    //
    public function schedule()
    {
        $exams = Exam::all();
        // $courses = Course::with(['major', 'year','tutors'])->get();
        // $years = Year::all();
        return view('schedule', ['exams'=>$exams]);
    }

}
