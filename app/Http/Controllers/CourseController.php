<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CourseController extends Controller
{
    //
    public function Courses()
    {
        return view('Courses');
    }

    public function LoadCourses(Request $request)
    {
        $term = '202101';
        $courses = Schedule::select('sec_course', 'sec_long_title')->distinct()->where('SEC_TERM_CODE', $term)->where('SEC_COLLEGE', 'IT')->get();
        foreach ($courses as $course) {
            if (!str_contains($course['sec_course'], 'WM')) {
                // $sum = Schedule::select(DB::raw("SUM(SEC_ENROLLED_STUDENTS) as sum"))->distinct('sec_crn')->where('SEC_TERM_CODE', $term)->where('SEC_COURSE', $course['sec_course'])->groupBy('sec_crn')->get();
                $numbers = Schedule::select('sec_crn',"sec_enrolled_students")->distinct()->where('SEC_TERM_CODE', $term)->where('SEC_COURSE', $course['sec_course'])->get();
                $sum = 0;
                foreach($numbers as $number){
                    $sum = $sum + $number['sec_enrolled_students'];
                }
                $ccourse = Course::where('course_code', $course['sec_course'])->firstOrCreate(
                    [
                        'course_code' => $course['sec_course'],
                        'course_title' => $course['sec_long_title'],
                        'number_of_students' => $sum,
                        'year_id' => 1,
                        'major_id' => 1,
                    ]
                );
            } else {
            }
        }
    }
}
