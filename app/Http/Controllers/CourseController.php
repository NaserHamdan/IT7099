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

    public function Courses()
    {
        //$courses = Course::all();
        $courses = Course::with(['major', 'year','tutors'])->get();
        $years = Year::all();
        $majors = Major::all();
        $tutors = Tutor::all();
        $count = 0;
        foreach($courses as $course){
            if($course->reviewed == 0){
                $count++;
            }
        }
        // return $courses[0]->tutors[0]->tutor_name;
        return view('Courses', ['courses' => $courses,'years'=>$years,'majors'=>$majors,'tutors'=>$tutors,'count'=>$count]);
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

    public function updateCourses(Request $request){
        $data = $request->all();
        for($i=1;$i<=$data['count'];$i++){
            Course::where(['course_id'=>$data['course_id'.$i]])->update([
                'course_code' => $data['course_code'.$i],
                'course_title' => $data['course_title'.$i],
                'number_of_students' => $data['number_of_students'.$i],
                'marking_diffucality' => $data['marking_diffucality'.$i],
                'course_coordinator' => $data['course_coordinator'.$i],
                'have_exam' => $data['have_exam'.$i],
                'year_id' => $data['year_id'.$i],
                'major_id' => $data['major_id'.$i],
                'reviewed' => 1,
            ]);
        }
        return redirect('/Courses');
    }

}
