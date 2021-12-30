<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\course_tutor;
use App\Models\Schedule;
use App\Models\Tutor;
use Illuminate\Http\Request;

class LinkingController extends Controller
{
    //

    public static function linkCoursesTutors(Request $request)
    {
        $term = "202101";
        $courses = Course::all();
        foreach ($courses as $course) {
            $tutors = Schedule::select('sec_tutor')->distinct()->where('sec_course', $course->course_code)->where('sec_term_code', $term)->get();
            foreach ($tutors as $tutor) {
                if (!str_contains($tutor['sec_tutor'], 'NA')) {
                    $id = Tutor::select('tutor_id')->where('tutor_name', $tutor['sec_tutor'])->first();
                    $idd = isset($id['tutor_id']) ? $id['tutor_id'] : $tutor['sec_tutor'];
                    if(is_int($idd)){
                        course_tutor::firstOrCreate(['tutor_id'=>$idd,'course_id'=>$course->course_id]);
                    }else{
                        echo"error";
                    }

                }
            }
        }
    }
}
