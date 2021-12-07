<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Major;
use App\Models\Schedule;
use App\Models\Tutor;
use App\Models\Year;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;

class CourseController extends Controller
{
    //
    public function Courses()
    {
        //$courses = Course::all();
        $courses = Course::with(['major', 'year','tutors'])->get();
        $years = Year::all();
        $majors = Major::all();
        $tutors = Tutor::all();
        // return $courses[0]->tutors[0]->tutor_name;
        return view('Courses', ['courses' => $courses,'years'=>$years,'majors'=>$majors,'tutors'=>$tutors]);
    }

    public function EditCourses()
    {
        $courses = Course::all();

        return view('EditCourses', ['courses' => $courses]);
    }

    public function LoadCourses(Request $request)
    {
        $term = '202101';
        $courses = Schedule::select('sec_course', 'sec_long_title')->distinct()->where('SEC_TERM_CODE', $term)->where('SEC_COLLEGE', 'IT')->get();
        foreach ($courses as $course) {
            if (!str_contains($course['sec_course'], 'WM')) {
                // $sum = Schedule::select(DB::raw("SUM(SEC_ENROLLED_STUDENTS) as sum"))->distinct('sec_crn')->where('SEC_TERM_CODE', $term)->where('SEC_COURSE', $course['sec_course'])->groupBy('sec_crn')->get();
                $numbers = Schedule::select('sec_crn', "sec_enrolled_students")->distinct()->where('SEC_TERM_CODE', $term)->where('SEC_COURSE', $course['sec_course'])->get();
                $sum = 0;
                foreach ($numbers as $number) {
                    $sum = $sum + $number['sec_enrolled_students'];
                }
                $ccourse = Course::where('course_code', $course['sec_course'])->firstOrCreate(
                    [
                        'course_code' => $course['sec_course'],

                    ],
                    [
                        'course_title' => $course['sec_long_title'],
                        'number_of_students' => $sum,
                        'year_id' => 1,
                        'major_id' => 1,
                    ]
                );
            } else {
            }
        }
        LinkingController::linkCoursesTutors($request);
        return redirect('/Courses');
    }

}
