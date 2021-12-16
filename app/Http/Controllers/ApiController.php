<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\course_tutor;
use App\Models\Exam;
use App\Models\exams_labs;
use App\Models\invigilations;
use App\Models\Lab;
use App\Models\Tutor;
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
                'reviewed' => $data['reviewed'],
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

    public function fetchCourseData(Request $request)
    {
        $id = $request->id;
        //
        $course = Course::with('tutors')->where('course_id', $id)->first();
        return response(['course' => $course]);
    }

    public function editCourse(Request $request)
    {
        $data = $request->all();
        $course = Course::where('course_id', $data['course_id'])->Update(
            [
                'year_id' => $data['year_id'],
                'major_id' => $data['major_id'],
                'course_code' => $data['course_code'],
                'course_title' => $data['course_title'],
                'number_of_students' => $data['number_of_students'],
                'marking_diffucality' => $data['marking_diffucality'],
                'course_coordinator' => $data['course_coordinator'],
                'have_exam' => $data['have_exam'],
                'reviewed' => $data['reviewed'],
            ]
        );
        $course = Course::findOrFail($data['course_id']);
        $course->courses_tutors()->delete();
        $tutors = $data['tutor'];
        foreach ($tutors as $tutor_id) {
            if ($tutor_id != 0) {
                course_tutor::firstOrCreate(['tutor_id' => $tutor_id, 'course_id' => $course->course_id]);
            }
        }
        return redirect('/Courses');
    }

    public function addTutor(Request $request)
    {
        $data = $request->all();
        $tutor = Tutor::firstOrCreate(
            [
                'tutor_name' => $data['tutor_name']
            ],
            [
                'position' => $data['position'],
                'reviewed' => $data['reviewed']
            ]
        );
        return redirect('/Invigilators');
    }

    public function deleteTutor(Request $request)
    {
        $data = $request->all();
        $tutor = Tutor::findOrFail($data['tutor_id']);
        $tutor->delete();
        return redirect('/Invigilators');
    }

    public function fetchTutorData(Request $request)
    {
        $id = $request->id;
        $tutor = Tutor::where('tutor_id', $id)->first();
        return response(['tutor' => $tutor]);
    }

    public function editTutor(Request $request)
    {
        $data = $request->all();
        $tutor = Tutor::where('tutor_id', $data['tutor_id'])->Update(
            [
                'tutor_name' => $data['tutor_name'],
                'position' => $data['position'],
                'reviewed' => $data['reviewed'],
            ]
        );
        return redirect('/Invigilators');
    }

    public function addLab(Request $request)
    {
        $data = $request->all();
        $lab = Lab::firstOrCreate(
            [
                'room' => $data['room'],
                'building' => $data['building']
            ],
            [
                'max_capacity' => $data['max_capacity'],
                'available_capacity' => $data['available_capacity'],
                'reviewed' => $data['reviewed'],
            ]
        );
        return redirect('/Labs');
    }

    public function deleteLab(Request $request)
    {
        $data = $request->all();
        $lab = Lab::findOrFail($data['lab_id']);
        $lab->delete();
        return redirect('/Labs');
    }

    public function fetchLabData(Request $request)
    {
        $id = $request->id;
        //
        $lab = Lab::where('lab_id', $id)->first();
        // dd($lab);
        return response(['lab' => $lab]);
    }

    public function editLab(Request $request)
    {
        $data = $request->all();
        $lab = Lab::where('lab_id', $data['lab_id'])->Update(
            [
                'room' => $data['room'],
                'building' => $data['building'],
                'max_capacity' => $data['max_capacity'],
                'available_capacity' => $data['available_capacity'],
                'reviewed' => $data['reviewed'],
            ]
        );
        return redirect('/Labs');
    }

    public function updateLabs(Request $request)
    {
        $data = $request->all();
        $exam = Exam::findOrFail($data['id']);
        exams_labs::where(['exam_id'=>$data['id']])->delete();
        if (isset($data['labs'])) {
            foreach ($data['labs'] as $lab) {
                exams_labs::create(['exam_id' => $data['id'], 'lab_id' => $lab]);
            }
            $labs = exams_labs::where(['exam_id' => $data['id']])->with('labs')->get();
        }
        return response(['labs' => $labs??array()]);
    }

    public function updateInvigilators(Request $request)
    {
        $data = $request->all();
        $exam = Exam::findOrFail($data['id']);
        $exam->invigilations()->delete();
        if (isset($data['tutors'])) {
            foreach ($data['tutors'] as $tutor) {
                invigilations::create(['exam_id' => $data['id'], 'tutor_id' => $tutor, 'invigilation_type' => 'S', 'room' => 0]);
            }
            $invigilators = invigilations::where(['exam_id' => $data['id']])->with('tutor')->get();
        }
        return response(['invigilators' => $invigilators??array()]);
    }

    public function addExam(Request $request)
    {
        $data = $request->all();
        $exam = Exam::firstOrCreate(
            [
                'course_id' => $data['course_id'],
            ],
            [
                'timeslot_id' => $data['timeslot_id'],
                'date' => $data['date'],
            ]
        );
        return redirect('/Schedule');
    }

    public function deleteExam(Request $request)
    {
        $data = $request->all();
        $exam = Exam::findOrFail($data['exam_id']);
        $exam->delete();
        return redirect('/Schedule');
    }

}
