@extends('Layouts.app')
@section('title', 'Courses')
@section('content')
    @php
    if (count($courses) > 0) {
        $url = $_SERVER['REQUEST_URI'];
        if (isset(parse_url($url)['query'])) {
            $query = parse_url($url)['query'];
            $sort = explode('&', $query)[0];
            $column = explode('=', $sort)[0];
            $order = explode('=', $sort)[1];
            if (isset($_GET[$column])) {
                if ($_GET[$column] == 'asc') {
                    $courses = $courses->sortby($column);
                } elseif ($_GET[$column] == 'desc') {
                    $courses = $courses->sortByDesc($column);
                }
            }
        }
    }

    @endphp
    {{-- backdrop for modals --}}
    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="backdrop"></div>
    {{-- button options --}}
    <div class="max-w-fit mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 flex-row">
            @if(Auth::user()->admin == 1)
            <button
                class="text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-m px-4 py-2.5 text-center inline-flex items-center"
                onclick="toggleModal('Add-Courses')">Add</button>
            <button
                class="text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-m px-4 py-2.5 text-center inline-flex items-center"
                onclick="toggleModal('Edit-Course')">Edit</button>
            <button
                class="text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-m px-4 py-2.5 text-center inline-flex items-center"
                onclick="toggleModal('Delete-Course')">Delete</button>
            <button
                class="text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-m px-4 py-2.5 text-center inline-flex items-center"
                onclick="promptGetCourses()">Get Courses</button>
            <form id="gatCourses" action="{{ route('LoadCourses') }}" method="GET" class="d-none">
                @csrf
            </form>
            @endif
            <div class="dropdown relative">
                <button id="dropdownButton" onclick="toggleDropDown('sortByDropDown')"
                    class="text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-m px-4 py-2.5 text-center inline-flex items-center"
                    type="button">Sort By <svg class="ml-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg></button>
                <div id="sortByDropDown"
                    class="hidden z-10 w-44 text-base list-none fixed bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700">
                    <ul
                        class=" min-w-max absolute bg-gray-500 text-base z-50 float-left py-2 list-none text-left rounded-lg shadow-lg mt-1 m-0 bg-clip-padding border-none">
                        <li>
                            <a class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-white hover:bg-gray-100"
                                href="#" onclick="sortBy('year_id')">Year</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-white hover:bg-gray-100"
                                href="#" onclick="sortBy('major_id')">Major</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-white hover:bg-gray-100"
                                href="#" onclick="sortBy('course_code')">Course Code</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-white hover:bg-gray-100"
                                href="#" onclick="sortBy('course_title')">Course Title</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-white hover:bg-gray-100"
                                href="#" onclick="sortBy('number_of_students')">Number of Students</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-white hover:bg-gray-100"
                                href="#" onclick="sortBy('marking_diffucality')">Marking Diffucality</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        {{-- coursestable --}}
        <div class="flex flex-col mt-8">
            <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div
                    class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Year</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Major</th>

                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Course Code</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Course Title</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Number of Students</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Marking Diffucality</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Exams</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Course Coordinator</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50 text-center">
                                    Tutors</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($courses as $course)
                                <tr>

                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $course->year->number }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $course->major->major_name }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $course->course_code }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $course->course_title }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $course->number_of_students }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $course->marking_diffucality }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $course->have_exam }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $course->course_coordinator }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        @forelse ($course->tutors as $tutor)
                                            <div class="text-sm leading-5 text-gray-500">{{ $tutor->tutor_name }}</div>
                                        @empty
                                            <div class="text-sm leading-5 text-gray-500 text-center font-bold">-</div>
                                        @endforelse
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Add Course Modal --}}
    <div class=" hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
        id="Add-Courses">
        <div class="relative w-auto my-6 mx-auto max-w-none">
            <div
                class=" border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                {{-- modal header --}}
                <div class="flex items-start p-5 border-b border-solid border-gray-200 rounded-t">
                    <h3 class="text-3xl font-semibold">Add a new course</h3>
                </div>
                {{-- modal body --}}
                <div class="flex flex-row relative p-6  justify-between text-left ">
                    <div class="relative flex-col">
                        <form name='addCourse' id='addCourse' action=" {{ route('addCourse') }}" method="post">
                            @csrf
                            <label class="block mt-4">
                                <span class="text-gray-700">Year</span>
                                <select name="year_id" class="form-select mt-1 block w-full">
                                    {{-- <option>Select Year of Study</option> --}}
                                    @foreach ($years as $year)
                                        <option value="{{ $year->year_id }}">{{ $year->number }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="block mt-4">
                                <span class="text-gray-700">Major</span>
                                <select name="major_id" class="form-select mt-1 block w-full">
                                    {{-- <option>Select Major</option> --}}
                                    @foreach ($majors as $major)
                                        <option value="{{ $major->major_id }}">{{ $major->major_name }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="block">
                                <span class="text-gray-700">Course Code</span>
                                <input name="course_code" class="form-input mt-1 block w-full" placeholder="IT6001"
                                    required />
                            </label>

                            <label class="block">
                                <span class="text-gray-700">Course Title</span>
                                <input name="course_title" class="form-input mt-1 block w-full"
                                    placeholder="Computer Systems" required />
                            </label>

                            <label class="block">
                                <span class="text-gray-700">Number of Students</span>
                                <input name="number_of_students" class="form-input mt-1 block w-full" type="number"
                                    placeholder="i.e 90" required />
                            </label>
                            <label class="block mt-4">
                                <span class="text-gray-700">Marking Diffucality</span>
                                <select name="marking_diffucality" class="form-select mt-1 block w-full">
                                    {{-- <option>Select Marking Diffucality</option> --}}
                                    <option>Low</option>
                                    <option>Medium</option>
                                    <option>High</option>
                                </select>
                            </label>
                            <label class="block mt-4">
                                <span class="text-gray-700">Exams</span>
                                <select name="have_exam" class="form-select mt-1 block w-full">
                                    {{-- <option>Select Exams</option> --}}
                                    <option value="N">No Exams</option>
                                    <option value="M">Midterm Only</option>
                                    <option value="F">Final Only</option>
                                    <option value="B">Both Exams</option>
                                </select>
                            </label>
                            <label class="block mt-4">
                                <span class="text-gray-700">Course Coordinator</span>
                                <select name="course_coordinator" class="form-select mt-1 block w-full">
                                    {{-- <option>Select Tutor</option> --}}
                                    @foreach ($tutors as $tutor)
                                        <option value="{{ $tutor->tutor_name }}">{{ $tutor->tutor_name }}</option>
                                    @endforeach
                                </select>
                            </label>

                    </div>
                    <div class="relative flex flex-col">
                        <label class="block mt-4">
                            <span class="text-gray-700">Number of Tutors <span class="text-gray-500">.6 max</span></span>
                            <input name="numberOfTutors" type="number" id="numberOfTutors" onchange="addFields()" min=1
                                max=6 value="1" class="form-input mt-1 block w-full" required />
                        </label>

                        <label class="block mt-4" id="tutor1">
                            <span class="text-gray-700">Course Tutor</span>
                            <select name="tutor[]" id="select1" class="form-select mt-1 block w-full">
                                @foreach ($tutors as $tutor)
                                    <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block mt-4 hidden" id="tutor2">
                            <span class="text-gray-700">Course Tutor</span>
                            <select name="tutor[]" id="select2" class="form-select mt-1 block w-full">
                                <option value="0">Select 2nd Tutor</option>
                                @foreach ($tutors as $tutor)
                                    <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block mt-4 hidden" id="tutor3">
                            <span class="text-gray-700">Course Tutor</span>
                            <select name="tutor[]" id="select3" class="form-select mt-1 block w-full">
                                <option value="0">Select 3rd Tutor</option>
                                @foreach ($tutors as $tutor)
                                    <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block mt-4 hidden" id="tutor4">
                            <span class="text-gray-700">Course Tutor</span>
                            <select name="tutor[]" id="select4" class="form-select mt-1 block w-full">
                                <option value="0">Select 4th Tutor</option>
                                @foreach ($tutors as $tutor)
                                    <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block mt-4 hidden" id="tutor5">
                            <span class="text-gray-700">Course Tutor</span>
                            <select name="tutor[]" id="select5" class="form-select mt-1 block w-full">
                                <option value="0">Select 5th Tutor</option>
                                @foreach ($tutors as $tutor)
                                    <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block mt-4 hidden" id="tutor6">
                            <span class="text-gray-700">Course Tutor</span>
                            <select name="tutor[]" id="select6" class="form-select mt-1 block w-full">
                                <option value="0">Select 6th Tutor</option>
                                @foreach ($tutors as $tutor)
                                    <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="hidden">
                            <input name="reviewed" type='number' value='1' class="form-input mt-1 block w-full" required />
                        </label>
                    </div>
                    </form>
                </div>
                {{-- modal footer --}}
                <div class="flex items-center justify-end p-6 border-t border-solid border-gray-200 rounded-b">
                    <button
                        class="text-blue-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" onclick="toggleModal('Add-Courses');clearInputs('addCourse')">Close</button>

                    <button
                        class="bg-blue-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2 rounded shadow
                    hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="submit" form='addCourse'>
                        Add Course
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Course Modal --}}
    <div class=" hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
        id="Edit-Course">
        <div class="relative w-auto my-6 mx-auto max-w-none">
            <div
                class=" border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                {{-- modal header --}}
                <div class="flex items-start p-5 border-b border-solid border-gray-200 rounded-t">
                    <h3 class="text-3xl font-semibold">Edit a Course</h3>
                </div>
                {{-- modal body --}}
                <div class="flex flex-row relative p-6  justify-between text-left ">
                    <div class="relative flex-col">
                        <form name='editCourse' id='editCourse' action=" {{ route('editCourse') }}" method="post">
                            @csrf
                            <label class="block mt-4">
                                <span class="text-gray-700">Course Code</span>
                                <select name="course_id"
                                    onchange="setValues('{{ route('fetchCourseData') }}',this.value)"
                                    class="form-select mt-1 block w-full">
                                    @foreach ($courses as $course)
                                        <option value="{{ $course->course_id }}">
                                            {{ $course->course_code . ' - ' . $course->course_title }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="block mt-4">
                                <span class="text-gray-700">Year</span>
                                <select id="year_id" name="year_id" class="form-select mt-1 block w-full">
                                    @foreach ($years as $year)
                                        <option value="{{ $year->year_id }}">{{ $year->number }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="block mt-4">
                                <span class="text-gray-700">Major</span>
                                <select id="major_id" name="major_id" class="form-select mt-1 block w-full">
                                    {{-- <option>Select Major</option> --}}
                                    @foreach ($majors as $major)
                                        <option value="{{ $major->major_id }}">{{ $major->major_name }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="block">
                                <span class="text-gray-700">Course Code</span>
                                <input id="course_code" name="course_code" value=""
                                    class="form-input mt-1 block w-full" placeholder="IT6001" required />
                            </label>

                            <label class="block">
                                <span class="text-gray-700">Course Title</span>
                                <input id="course_title" name="course_title" value=""
                                    class="form-input mt-1 block w-full" placeholder="Computer Systems" required />
                            </label>

                            <label class="block">
                                <span class="text-gray-700">Number of Students</span>
                                <input id="number_of_students" name="number_of_students"
                                    class="form-input mt-1 block w-full" type="number"
                                    value="" placeholder="i.e 90" required />
                            </label>
                            <label class="block mt-4">
                                <span class="text-gray-700">Marking Diffucality</span>
                                <select id="marking_diffucality" name="marking_diffucality"
                                    value=""
                                    class="form-select mt-1 block w-full">
                                    {{-- <option>Select Marking Diffucality</option> --}}
                                    <option value="Low">Low</option>
                                    <option value="Medium" >Medium</option>
                                    <option value="High" >High</option>
                                </select>
                            </label>
                            <label class="block mt-4">
                                <span class="text-gray-700">Exams</span>
                                <select id="have_exam" name="have_exam" class="form-select mt-1 block w-full">
                                    <option value="N" >No Exams</option>
                                    <option value="M">Midterm Only</option>
                                    <option value="F" >Final Only</option>
                                    <option value="B">Both Exams</option>
                                </select>
                            </label>
                            <label class="block mt-4">
                                <span class="text-gray-700">Course Coordinator</span>
                                <select id="course_coordinator" name="course_coordinator"
                                    class="form-select mt-1 block w-full">
                                    <option value="NA">NA</option>
                                    @foreach ($tutors as $tutor)
                                        <option value="{{ $tutor->tutor_name }}">
                                            {{ $tutor->tutor_name }}</option>
                                    @endforeach
                                </select>
                            </label>
                    </div>
                    <div class="relative flex flex-col">
                        <label class="block mt-4">
                            <span class="text-gray-700">Number of Tutors <span class="text-gray-500">.6
                                    max</span></span>
                            <input id="numberOfTutorsE" name="numberOfTutors" type="number" id="numberOfTutorsE"
                                onchange="addFieldsE()" min=1 max=6 value=""
                                class="form-input mt-1 block w-full" required />
                        </label>

                        <label class="block mt-4" id="tutor1E">
                            <span class="text-gray-700">Course Tutor</span>
                            <select name="tutor[]" id="select1E" class="form-select mt-1 block w-full">
                                @foreach ($tutors as $tutor)
                                    <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block mt-4 hidden" id="tutor2E">
                            <span class="text-gray-700">Course Tutor</span>
                            <select name="tutor[]" id="select2E" class="form-select mt-1 block w-full">
                                <option value="0">Select 2nd Tutor</option>
                                @foreach ($tutors as $tutor)
                                    <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block mt-4 hidden" id="tutor3E">
                            <span class="text-gray-700">Course Tutor</span>
                            <select name="tutor[]" id="select3E" class="form-select mt-1 block w-full">
                                <option value="0">Select 3rd Tutor</option>
                                @foreach ($tutors as $tutor)
                                    <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block mt-4 hidden" id="tutor4E">
                            <span class="text-gray-700">Course Tutor</span>
                            <select name="tutor[]" id="select4E" class="form-select mt-1 block w-full">
                                <option value="0">Select 4th Tutor</option>
                                @foreach ($tutors as $tutor)
                                    <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block mt-4 hidden" id="tutor5E">
                            <span class="text-gray-700">Course Tutor</span>
                            <select name="tutor[]" id="select5E" class="form-select mt-1 block w-full">
                                <option value="0">Select 5th Tutor</option>
                                @foreach ($tutors as $tutor)
                                    <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block mt-4 hidden" id="tutor6E">
                            <span class="text-gray-700">Course Tutor</span>
                            <select name="tutor[]" id="select6E" class="form-select mt-1 block w-full">
                                <option value="0">Select 6th Tutor</option>
                                @foreach ($tutors as $tutor)
                                    <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="hidden">
                            <input id="reviewed" name="reviewed" type='number' value='1'
                                class="form-input mt-1 block w-full" required />
                        </label>
                    </div>
                    </form>
                </div>
                {{-- modal footer --}}
                <div class="flex items-center justify-end p-6 border-t border-solid border-gray-200 rounded-b">
                    <button
                        class="text-blue-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button"
                        onclick="toggleModal('Edit-Course');clearInputs('editCourse');document.getElementById('numberOfTutorsE').value=1;addFieldsE()">Close</button>

                    <button
                        class="bg-blue-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2
                rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="submit" form="editCourse">
                        Edit Course
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Course Modal --}}
    <div class=" hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
        id="Delete-Course">
        <div class="relative w-auto my-6 mx-auto max-w-none">
            <div
                class=" border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                {{-- modal header --}}
                <div class="flex items-start p-5 border-b border-solid border-gray-200 rounded-t">
                    <h3 class="text-3xl font-semibold">Delete a course</h3>
                </div>
                {{-- modal body --}}
                <div class="flex flex-row relative p-6  justify-between text-left ">
                    <form name='deleteCourse' id='deleteCourse' action=" {{ route('deleteCourse') }}" method="post">
                        @csrf
                        <label class="block mt-4">
                            <span class="text-gray-700">Course Code</span>
                            <select name="course_id" class="form-select mt-1 block w-full">
                                @foreach ($courses as $course)
                                    <option value="{{ $course->course_id }}">
                                        {{ $course->course_code . ' - ' . $course->course_title }}</option>
                                @endforeach
                            </select>
                        </label>
                    </form>
                </div>
                {{-- modal footer --}}
                <div class="flex items-center justify-end p-6 border-t border-solid border-gray-200 rounded-b">
                    <button
                        class="text-blue-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" onclick="toggleModal('Delete-Course');clearInputs('deleteCourse')">Close</button>

                    <button
                        class="bg-red-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2 rounded shadow
                    hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" onclick="promptDelete()">
                        Delete Course
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Review Course Modal --}}
    <div class=" hidden overflow-x-hidden overflow-y-auto mt-10 fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
        id="Review-Course">
        <div class="relative w-auto my-auto mx-auto max-w-none">
            <div
                class=" border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                {{-- modal header --}}
                <div class="flex items-start p-5 border-b border-solid border-gray-200 rounded-t">
                    <h3 class="text-3xl font-semibold">Review Courses</h3>
                </div>
                {{-- modal body --}}
                <div class="flex flex-row relative p-6  justify-between text-left ">
                    <form name='reviewCourse' id='reviewCourse' action=" {{ route('updateCourses') }}" method="post">
                        @csrf
                        @php
                            $index = 1;
                            $lines = [];
                        @endphp
                        @foreach ($courses as $course)
                            @if ($course->reviewed == 0)
                                @php
                                    $lines[] = "setValuesReview({$course->course_id},{$index})";
                                @endphp
                                <div class="flex-col">
                                    <h6 class="font-semibold">Course {{ $index }}</h6>
                                    <input type="hidden" name="course_id{{ $index }}"
                                        value="{{ $course->course_id }}" />
                                    <label class="block mt-4">
                                        <span class="text-gray-700">Year</span>
                                        <select id="year_id{{ $index }}" name="year_id{{ $index }}"
                                            class="form-select mt-1 block w-full">
                                            @foreach ($years as $year)
                                                <option value="{{ $year->year_id }}" @if ($year->year_id == $course->year_id){{ 'selected' }}@endif>
                                                    {{ $year->number }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label class="block mt-4">
                                        <span class="text-gray-700">Major</span>
                                        <select id="major_id{{ $index }}" name="major_id{{ $index }}"
                                            class="form-select mt-1 block w-full">
                                            {{-- <option>Select Major</option> --}}
                                            @foreach ($majors as $major)
                                                <option value="{{ $major->major_id }}" @if ($major->major_id == $course->major_id){{ 'selected' }}@endif>
                                                    {{ $major->major_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label class="block">
                                        <span class="text-gray-700">Course Code</span>
                                        <input id="course_code{{ $index }}" name="course_code{{ $index }}"
                                            value="{{ $course->course_code }}" class="form-input mt-1 block w-full"
                                            placeholder="IT6001" required />
                                    </label>

                                    <label class="block">
                                        <span class="text-gray-700">Course Title</span>
                                        <input id="course_title{{ $index }}" name="course_title{{ $index }}"
                                            value="{{ $course->course_title }}" class="form-input mt-1 block w-full"
                                            placeholder="Computer Systems" required />
                                    </label>

                                    <label class="block">
                                        <span class="text-gray-700">Number of Students</span>
                                        <input id="number_of_students{{ $index }}"
                                            name="number_of_students{{ $index }}"
                                            class="form-input mt-1 block w-full" type="number"
                                            value="{{ $course->number_of_students }}" placeholder="i.e 90" required />
                                    </label>
                                    <label class="block mt-4">
                                        <span class="text-gray-700">Marking Diffucality</span>
                                        <select id="marking_diffucality{{ $index }}"
                                            name="marking_diffucality{{ $index }}"
                                            class="form-select mt-1 block w-full">
                                            <option value="Low" @if ($course->marking_diffucality == 'Low'){{ 'selected' }}@endif>Low</option>
                                            <option value="Medium" @if ($course->marking_diffucality == 'Mdeium'){{ 'selected' }}@endif>Medium</option>
                                            <option value="High" @if ($course->marking_diffucality == 'High'){{ 'selected' }}@endif>High</option>
                                        </select>
                                    </label>
                                    <label class="block mt-4">
                                        <span class="text-gray-700">Exams</span>
                                        <select id="have_exam{{ $index }}" name="have_exam{{ $index }}"
                                            class="form-select mt-1 block w-full">
                                            <option value="N" @if ($course->have_exam == 'N'){{ 'selected' }}@endif>No Exams</option>
                                            <option value="M" @if ($course->have_exam == 'M'){{ 'selected' }}@endif>Midterm Only</option>
                                            <option value="F" @if ($course->have_exam == 'F'){{ 'selected' }}@endif>Final Only</option>
                                            <option value="B" @if ($course->have_exam == 'B'){{ 'selected' }}@endif>Both Exams</option>
                                        </select>
                                    </label>
                                    <label class="block mt-4">
                                        <span class="text-gray-700">Course Coordinator</span>
                                        <select id="course_coordinator{{ $index }}"
                                            name="course_coordinator{{ $index }}"
                                            class="form-select mt-1 block w-full">
                                            <option value="NA">NA</option>
                                            @foreach ($tutors as $tutor)
                                                <option value="{{ $tutor->tutor_name }}" @if ($course->course_coordinator == $tutor->tutor_name){{ 'selected' }}@endif>
                                                    {{ $tutor->tutor_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>

                                </div>
                                <div class="relative flex flex-col">
                                    <label class="block mt-4">
                                        <span class="text-gray-700">Number of Tutors <span class="text-gray-500">.6
                                                max</span></span>
                                        <input id="numberOfTutors{{ $index }}"
                                            name="numberOfTutors{{ $index }}" type="number"
                                            onchange="addFieldsU({{ $index }},this.value)" min=0 max=6 value="1"
                                            class="form-input mt-1 block w-full" required />
                                    </label>

                                    <label class="block mt-4" id="tutor1U{{ $index }}">
                                        <span class="text-gray-700">Course Tutor</span>
                                        <select name="tutor[]" id="select1U{{ $index }}"
                                            class="form-select mt-1 block w-full">
                                            @foreach ($tutors as $tutor)
                                                <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label class="block mt-4 hidden" id="tutor2U{{ $index }}">
                                        <span class="text-gray-700">Course Tutor</span>
                                        <select name="tutor[]" id="select2U{{ $index }}"
                                            class="form-select mt-1 block w-full">
                                            <option value="0">Select 2nd Tutor</option>
                                            @foreach ($tutors as $tutor)
                                                <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label class="block mt-4 hidden" id="tutor3U{{ $index }}">
                                        <span class="text-gray-700">Course Tutor</span>
                                        <select name="tutor[]" id="select3U{{ $index }}"
                                            class="form-select mt-1 block w-full">
                                            <option value="0">Select 3rd Tutor</option>
                                            @foreach ($tutors as $tutor)
                                                <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label class="block mt-4 hidden" id="tutor4U{{ $index }}">
                                        <span class="text-gray-700">Course Tutor</span>
                                        <select name="tutor[]" id="select4U{{ $index }}"
                                            class="form-select mt-1 block w-full">
                                            <option value="0">Select 4th Tutor</option>
                                            @foreach ($tutors as $tutor)
                                                <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label class="block mt-4 hidden" id="tutor5U{{ $index }}">
                                        <span class="text-gray-700">Course Tutor</span>
                                        <select name="tutor[]" id="select5U{{ $index }}"
                                            class="form-select mt-1 block w-full">
                                            <option value="0">Select 5th Tutor</option>
                                            @foreach ($tutors as $tutor)
                                                <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <label class="block mt-4 hidden" id="tutor6U{{ $index }}">
                                        <span class="text-gray-700">Course Tutor</span>
                                        <select name="tutor[]" id="select6U{{ $index }}"
                                            class="form-select mt-1 block w-full">
                                            <option value="0">Select 6th Tutor</option>
                                            @foreach ($tutors as $tutor)
                                                <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </label>
                                    <hr
                                        onload="setValuesReview(route('fetchCourseData'),{{ $course->course_id }},{{ $index }})" />
                                    @php
                                        $index++;
                                    @endphp
                            @endif
                        @endforeach
                        <input type='hidden' name="count" value="{{ $index - 1 }}" />
                    </form>
                </div>
                {{-- modal footer --}}
                <div class="flex items-center justify-end p-6 border-t border-solid border-gray-200 rounded-b">
                    <button
                        class="text-blue-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" onclick="toggleModal('Review-Course');clearInputs('reviewCourse');">Close</button>

                    <button
                        class="bg-blue-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2 rounded shadow
hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="submit" form='reviewCourse'>
                        Confirm Courses
                    </button>
                </div>
            </div>
        </div>
    </div>


    <script type="text/javascript">

        function sortBy(column) {
            if (getQueryVariable(`${column}`) == -1) {
                window.location.replace(`{{ route('Courses') }}?${column}=asc`);
            } else if (getQueryVariable(`${column}`) == 'asc') {
                window.location.replace(`{{ route('Courses') }}?${column}=desc`);
            } else {
                window.location.replace("{{ route('Courses') }}");
            }
        }

        function getQueryVariable(variable) {
            var query = window.location.search.substring(1);
            var vars = query.split("&");
            for (var i = 0; i < vars.length; i++) {
                var pair = vars[i].split("=");
                if (pair[0] == variable) {
                    return pair[1];
                }
            }
            return -1; //not found
        }

        function toggleDropDown(dropDownID) {
            document.getElementById(dropDownID).classList.toggle("hidden");
            document.getElementById(dropDownID).classList.toggle("flex");
        }

        function toggleModal(modalID) {
            document.getElementById(modalID).classList.toggle("hidden");
            document.getElementById("backdrop").classList.toggle("hidden");
            document.getElementById(modalID).classList.toggle("flex");
            document.getElementById("backdrop").classList.toggle("flex");
        }



        $(document).ready(function() {
            setValues("{{ route('fetchCourseData') }}", '{{ $courses[0]->course_id??1 }}');
            var count = {{ $count }};
            if (count > 0) {
                @for ($i = 1; $i <= $count; $i++)
                    {{ $lines[$i - 1] }};
                @endfor
                toggleModal('Review-Course');
            } else {

            }
        });

        function addFields() {
            var numberOfTutors = document.getElementById("numberOfTutors");

            if (numberOfTutors.value < 1) {
                numberOfTutors.value = 1;
            } else if (numberOfTutors.value > 6) {
                numberOfTutors.value = 6;
            }

            for (var i = 2; i <= 6; i++) {
                if (!document.getElementById("tutor" +
                        i).classList.contains('hidden') && i > numberOfTutors.value) {
                    document.getElementById("tutor" + i).classList.toggle('hidden');
                    document.getElementById("select" + i).setAttribute("disabled", "disabled");
                } else if (document.getElementById("tutor" + i).classList.contains('hidden') && i <=
                    numberOfTutors.value) {
                    document.getElementById("tutor" +
                        i).classList.toggle("hidden");
                    document.getElementById("select" +
                        i).removeAttribute("disabled");
                }
            }
        }

        function addFieldsE() {
            var
                numberOfTutors = document.getElementById("numberOfTutorsE");
            if (numberOfTutors.value <
                1) {
                numberOfTutors.value = 1;
            } else if (numberOfTutors.value > 6) {
                numberOfTutors.value = 6;
            }

            for (var i = 2; i <= 6; i++) {
                if (!document.getElementById("tutor" + i + "E").classList.contains('hidden') && i > numberOfTutors.value) {
                    document.getElementById("tutor" + i + "E").classList.toggle('hidden');
                    document.getElementById("select" + i + "E").setAttribute("disabled",
                        "disabled");
                } else if (document.getElementById("tutor" + i +
                        "E").classList.contains('hidden') && i <= numberOfTutors.value) {
                    document.getElementById("tutor" + i + "E").classList.toggle("hidden");
                    document.getElementById("select" + i + "E").removeAttribute("disabled");
                }
            }
        }

        function clearInputs(formName) {
            document.getElementById(formName).reset();
        }

        function promptDelete() {
            if (confirm("Are you sure you want to delete the course?") == true) {
                document.getElementById('deleteCourse').submit();
            } else {}
        }

        function
        promptGetCourses() {
            if (confirm("Are you sure you want to get all unregistred courses from the database ? ") == true) {
                event.preventDefault();
                document.getElementById('gatCourses').submit();
            } else {}
        }

        function
        setValues(url, courseId) {
            fetch(`${url}?id=${courseId}`).then(response =>
                    response.json())
                .then(data => {
                    document.getElementById('course_code').value = data.course.course_code;
                    document.getElementById('course_title').value = data.course.course_title;
                    document.getElementById('number_of_students').value =
                        data.course.number_of_students;
                    document.getElementById('marking_diffucality').value =
                        data.course.marking_diffucality;
                    document.getElementById('course_coordinator').value =
                        data.course.course_coordinator;
                    document.getElementById('have_exam').value = data.course.have_exam;
                    document.getElementById('reviewed').value = data.course.reviewed;
                    document.getElementById('year_id').value = data.course.year_id;
                    document.getElementById('major_id').value = data.course.major_id;
                    document.getElementById('numberOfTutorsE').value =
                        data.course.tutors.length;
                    addFieldsE();
                    fillFieldsE(data.course.tutors);
                });
        }

        function setValuesReview(courseId, index) {
            var url = "{{ route('fetchCourseData') }}";
            fetch(`${url}?id=${courseId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('course_code' + index).value =
                        data.course.course_code;
                    document.getElementById('course_title' + index).value =
                        data.course.course_title;
                    document.getElementById('number_of_students' + index).value =
                        data.course.number_of_students;
                    document.getElementById('marking_diffucality' + index).value =
                        data.course.marking_diffucality;
                    document.getElementById('course_coordinator' + index).value =
                        data.course.course_coordinator;
                    document.getElementById('have_exam' + index).value = data.course.have_exam;
                    document.getElementById('year_id' + index).value = data.course.year_id;
                    document.getElementById('major_id' + index).value = data.course.major_id;
                    document.getElementById('numberOfTutors' + index).value = data.course.tutors.length;
                    fillFieldsU(data.course.tutors, index);
                    addFieldsU(index, data.course.tutors.length);
                });
        }

        function addFieldsU(index, object) {
            var numberOfTutors = object;
            if (numberOfTutors < 1) {
                numberOfTutors = 1;
            } else if (numberOfTutors > 6) {
                numberOfTutors = 6;
            }

            for (var i = 2; i <= 6; i++) {
                if (!document.getElementById("tutor" + i +
                        "U" + index).classList.contains('hidden') && i > numberOfTutors) {
                    document.getElementById("tutor" + i + "U" +
                        index).classList.toggle('hidden');
                    document.getElementById("select" + i + "U" +
                        index).setAttribute("disabled", "disabled");
                } else if (document.getElementById("tutor" + i + "U" +
                        index).classList.contains('hidden') && i <= numberOfTutors) {
                    document.getElementById("tutor" + i + "U" +
                        index).classList.toggle("hidden");
                    document.getElementById("select" + i + "U" +
                        index).removeAttribute("disabled");
                }
            }
        }

        function
        fillFieldsU(tutors, index) {
            var numberOfTutors = tutors.length;
            for (var i = 1; i <= tutors.length; i++) {
                var count = i - 1;
                document.getElementById('select' + i + "U" +
                    index).value = tutors[count].tutor_id;
            }
        }

        function
        fillFieldsE(tutors) {
            var numberOfTutors = tutors.length;
            for (var
                    i = 1; i <= tutors.length; i++) {
                var index = i - 1;
                document.getElementById('select' + i + "E").value = tutors[index].tutor_id;
            }
        }
    </script>
@endsection
