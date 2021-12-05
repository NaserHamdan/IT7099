@extends('Layouts.app')
@section('title', 'Courses')
@section('content')
    <div>
        <button class="" action="{{Route('EditCourses')}}">edit</button>
    </div>
    <div>
        <table border="1" class="mx-auto">
            <tr>
                <th>Year</th>
                <th>Major</th>
                <th>Course Code</th>
                <th>Course Title</th>
                <th>Number Of Students</th>
                <th>Marking Diffucality</th>
                <th>Have Exam</th>
                <th>Course Coordinator</th>
                <th>Teachers</th>
            </tr>
            @foreach ($courses as $course)
                <tr>
                    <td>{{ $course->year_id }}</td>
                    <td>{{ $course->major_id }}</td>
                    <td>{{ $course->course_code }}</td>
                    <td>{{ $course->course_title }}</td>
                    <td>{{ $course->number_of_students }}</td>
                    <td>{{ $course->marking_diffucality }}</td>
                    <td>{{ $course->have_exam }}</td>
                    <td>{{ $course->course_coordinator }}</td>
                    <td>{{ 0 }}</td>
                </tr>
            @endforeach
        </table>
    </div>

@endsection
