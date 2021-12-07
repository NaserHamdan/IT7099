<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\course_tutor;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    //
    // public function addCourse(Request $request){
    //     dd($request->all());
    //     return view('testing',['request'=>$request]);
    // }

    public function addCourse(Request $request)
    {
        $data = $request->all();
        $course = Course::firstOrCreate(
            ['course_code' => $data['course_code']],
            [
                'year_id' => $data['year_id'],
                'major_id' => $data['major_id'],
                'course_title' => $data['course_title'],
                'number_of_students' => $data['number_of_students'],
                'marking_diffucality' => $data['marking_diffucality'],
                'have_exam' => $data['have_exam'],
                'course_coordinator' => $data['course_coordinator'],
            ]
        );
        $tutors = $data['tutor'];
        foreach ($tutors as $tutor_id) {
            if ($tutor_id != 0) {
                course_tutor::firstOrCreate(['tutor_id' => $tutor_id, 'course_id' => $course->course_id]);
            }
        }
        return redirect('/Courses');
    }

    public function deleteCourse(Request $request)
    {
        $data = $request->all();
        $course = Course::findOrFail($data['course_id']);
        $course->courses_tutors()->delete();
        $course->exams()->delete();
        $course->delete();
        return redirect('/Courses');
    }
}
