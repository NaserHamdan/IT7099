@extends('Layouts.app')
@section('title', 'Schedule')
@section('content')
    @php

    $url = $_SERVER['REQUEST_URI'];
    if (isset(parse_url($url)['query'])) {
        $query = parse_url($url)['query'];
        $sort = explode('&', $query)[0];
        $column = explode('=', $sort)[0];
        $order = explode('=', $sort)[1];
        if (isset($_GET[$column])) {
            if ($_GET[$column] == 'asc') {
                $exams = $exams->sortby($column);
            } elseif ($_GET[$column] == 'desc') {
                $exams = $exams->sortByDesc($column);
            }
        }
    }
    @endphp
    {{-- backdrop for modals --}}
    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="backdrop"></div>
    {{-- button options --}}
    <div class="max-w-fit mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 flex-row">
            <button
                class="text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-m px-4 py-2.5 text-center inline-flex items-center"
                onclick="toggleModal('Add-Exam')">Add</button>
            <button
                class="text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-m px-4 py-2.5 text-center inline-flex items-center"
                onclick="toggleModal('Edit-Exam')">Edit</button>
            <button
                class="text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-m px-4 py-2.5 text-center inline-flex items-center"
                onclick="toggleModal('Delete-Exam')">Delete</button>
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
                                href="#" onclick="sortBy('date')">Date</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-white hover:bg-gray-100"
                                href="#" onclick="sortBy('timeslot_id')">Timeslot</a>
                        </li>
                    </ul>
                </div>
            </div>
            <button
                class="text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-m px-4 py-2.5 text-center inline-flex items-center"
                onclick="downloadPdf()">Print/Export</button>
            <label
                class="text-white m-0 bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-m px-4 py-2.5 text-center inline-flex items-center"
                for="start_date">Start Date</label>
            <input id="start_date" value="" name="start_date" min="{{ date('Y-m-d') }}" type="date"
                class="form-input font-bold py-2 px-4 rounded" required />
        </div>
        {{-- courses table --}}
        <div id="table" class="flex flex-col mt-8 print:landscape">
            <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div
                    class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full">
                        <thead class="table-row-group">
                            <tr>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Year</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Major</th>

                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Course</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Day</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Time Slot</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Labs Allocated</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Invigilators</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @php
                                $index = 0;
                            @endphp
                            @foreach ($exams as $exam)
                                @php
                                    $index++;
                                @endphp
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $exam->course->year->number }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4whitespace-nowrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">
                                            {{ $exam->course->major->major_name }}</div>
                                    </td>
                                    <td class="px-6 border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">
                                            {{ $exam->course->course_code . ' - ' . $exam->course->course_title }}</div>
                                    </td>
                                    <td class="px-6 py-4 border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">
                                            {{ date('l d/m/Y', strtotime($exam->date)) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-normal border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">
                                            {{ date('H:i', strtotime($exam->timeslot->start_time)) . ' - ' . date('H:i', strtotime($exam->timeslot->end_time)) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 h-auto w-1/4 whitespace-normal border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">
                                            <p class="p-0 m-0" id="PL-{{ $exam->exam_id }}"
                                                onclick="showCheckboxes('L-{{ $index }}')">
                                                @php
                                                    $length = count($exam->labs);
                                                @endphp
                                                @if (count($exam->labs) == 0)
                                                    <span
                                                        class='border-2 border-yellow-200 rounded-lg p-1 cursor-pointer mr-1 bg-yellow-100 hover:bg-yellow-200 leading-9 '>
                                                        {{ 'No Labs are assigned for this exam' }}
                                                    </span>
                                                @else
                                                    @foreach ($exam->labs as $i => $lab)
                                                        <span id="E{{ $exam->exam_id }}L{{ $lab->lab_id }}"
                                                            class='border-2 rounded-lg p-1 mr-1 leading-9 cursor-pointer'>
                                                            {{ $lab->room }}
                                                        </span>
                                                    @endforeach
                                                @endif
                                            </p>
                                            <div id="L-{{ $index }}" class=" hidden mt-2">
                                                <select id="multi" name="labs[]"
                                                    onclick="updateLabs(this,'{{ route('updateLabs') }}', '{{ $exam->exam_id }}');"
                                                    class="form-multiselect multi block w-full mt-1 " multiple>
                                                    @foreach ($labs as $lab)
                                                        <option class="" value="{{ $lab->lab_id }}"
                                                            @foreach ($exam->labs as $elab)
                                                            @if ($elab->lab_id == $lab->lab_id)
                                                                {{ 'selected' }}
                                                            @endif
                                                    @endforeach
                                                    >
                                                    {{ $lab->room }}
                                                    </option>
                            @endforeach
                            </select>
                </div>
                </td>
                {{-- comment --}}
                <td class="px-6 py-4 h-auto w-1/4 whitespace-normal border-b border-gray-200">
                    <div class="text-sm leading-5 text-gray-500">
                        <p class="p-0 m-0" id="PI-{{ $exam->exam_id }}"
                            onclick="showCheckboxes('I-{{ $index }}')">
                            @php
                                $length = count($exam->tutors);
                            @endphp
                            @if (count($exam->tutors) == 0)
                                <span
                                    class='border-2 border-yellow-200 rounded-lg p-1 mr-1 bg-yellow-100 hover:bg-yellow-200 leading-9 cursor-pointer'>
                                    {{ 'No Invigilators are assigned for this exam' }}
                                </span>
                            @else
                                @foreach ($exam->tutors as $i => $tutor)
                                    <span id="E{{ $exam->exam_id }}T{{ $tutor->tutor_id }}"
                                        class='border-2 rounded-lg p-1 mr-1 leading-9 cursor-pointer'>
                                        {{ $tutor->tutor_name }}
                                    </span>
                                @endforeach
                            @endif
                        </p>
                        <div id="I-{{ $index }}" class=" hidden mt-2">
                            <select id="multi" name="tutors[]"
                                onclick="updateInvigilators(this,'{{ route('updateInvigilators') }}', '{{ $exam->exam_id }}');"
                                class="form-multiselect multi block w-full mt-1" multiple>
                                @foreach ($tutors as $tutor)
                                    <option class="checked:bg-green-300 " value="{{ $tutor->tutor_id }}" @foreach ($exam->invigilations as $invigilation)
                                        @if ($invigilation->tutor_id == $tutor->tutor_id)
                                            {{ 'selected' }}
                                        @endif
                                @endforeach
                                >
                                {{ $tutor->tutor_name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                </td>
                </tr>
                @endforeach
                </tbody>
                </table>
            </div>
        </div>
    </div>
    </div>

    {{-- Add Exam Modal --}}
    <div class=" hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
        id="Add-Exam">
        <div class="relative w-auto my-6 mx-auto max-w-none">
            <div
                class=" border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                {{-- modal header --}}
                <div class="flex items-start p-5 border-b border-solid border-gray-200 rounded-t">
                    <h3 class="text-3xl font-semibold">Add a new exam</h3>
                </div>
                {{-- modal body --}}
                <div class="flex flex-col relative p-6  justify-between text-left ">
                    <form name='addExam' id='addExam' action="{{ route('addExam') }}" method="post">
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
                        <label class="block">
                            <span class="text-gray-700">Exam Date</span>
                            <input name="date" type="date" min="{{ date('Y-m-d H:i:s') }}"
                                class="form-input mt-1 block w-full" placeholder="" required />
                        </label>
                        <label class="block mt-4">
                            <span class="text-gray-700">Time slot</span>
                            <select name="timeslot_id" class="form-select mt-1 block w-full">
                                @foreach ($timeslots as $timeslot)
                                    <option value="{{ $timeslot->timeslot_id }}">
                                        {{ $timeslot->start_time . ' - ' . $timeslot->end_time }}</option>
                                @endforeach
                            </select>
                        </label>
                    </form>
                </div>
                {{-- modal footer --}}
                <div class="flex items-center justify-end p-6 border-t border-solid border-gray-200 rounded-b">
                    <button
                        class="text-blue-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" onclick="toggleModal('Add-Exam');clearInputs('addExam')">Close</button>

                    <button
                        class="bg-blue-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2 rounded shadow
                    hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="submit" form='addExam'>
                        Add Exam
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Exam Modal --}}
    <div class=" hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
        id="Edit-Exam">
        <div class="relative w-auto my-6 mx-auto max-w-none">
            <div
                class=" border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                {{-- modal header --}}
                <div class="flex items-start p-5 border-b border-solid border-gray-200 rounded-t">
                    <h3 class="text-3xl font-semibold">Edit a Exam</h3>
                </div>
                {{-- modal body --}}
                <div class="flex flex-row relative p-6  justify-between text-left ">
                    <form name='editExam' id='editExam' action="" method="post">
                        @csrf
                        <label class="block mt-4">
                            <span class="text-gray-700">Select Exam</span>
                            <select name="exam_id" onchange="setValues('{{ route('fetchCourseData') }}',this.value)"
                                class="form-select mt-1 block w-full">
                                @foreach ($exams as $exam)
                                    <option value="{{ $exam->exam_id }}">
                                        {{ $exam->course->course_code . ' - ' . $exam->course->course_title }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block mt-4">
                            <span class="text-gray-700">Course</span>
                            <select name="course_id" onchange="setValues('{{ route('fetchCourseData') }}',this.value)"
                                class="form-select mt-1 block w-full">
                                @foreach ($courses as $course)
                                    <option value="{{ $course->course_id }}">
                                        {{ $course->course_code . ' - ' . $course->course_title }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block mt-4">
                            <span class="text-gray-700">Time Slot</span>
                            <select id="timeslot_id" name="major_id" class="form-select mt-1 block w-full">
                                {{-- <option>Select Major</option> --}}
                                @foreach ($timeslots as $timeslot)
                                    <option value="{{ $timeslot->timeslot_id }}">
                                        {{ $timeslot->start_time . ' - ' . $timeslot->end_time }}
                                    </option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block">
                            <span class="text-gray-700">Course Code</span>
                            <input id="course_code" name="course_code" class="form-input mt-1 block w-full"
                                placeholder="IT6001" required />
                        </label>
                    </form>
                </div>
                {{-- modal footer --}}
                <div class="flex items-center justify-end p-6 border-t border-solid border-gray-200 rounded-b">
                    <button
                        class="text-blue-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" onclick="toggleModal('Edit-Exam');clearInputs('editExam')">Close</button>

                    <button
                        class="bg-blue-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2
                rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="submit" form="editExam">
                        Edit Exam
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Exam Modal --}}
    <div class=" hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
        id="Delete-Exam">
        <div class="relative w-auto my-6 mx-auto max-w-none">
            <div
                class=" border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                {{-- modal header --}}
                <div class="flex items-start p-5 border-b border-solid border-gray-200 rounded-t">
                    <h3 class="text-3xl font-semibold">Delete an exam</h3>
                </div>
                {{-- modal body --}}
                <div class="flex flex-row relative p-6  justify-between text-left ">
                    <form name='deleteExam' id='deleteExam' action="{{ route('deleteExam') }}" method="post">
                        @csrf
                        <label class="block mt-4">
                            <span class="text-gray-700">Exam</span>
                            <select name="exam_id" class="form-select mt-1 block w-full">
                                @foreach ($exams as $exam)
                                    <option value="{{ $exam->exam_id }}">
                                        {{ $exam->course->course_code . ' - ' . $exam->course->course_title }}</option>
                                @endforeach
                            </select>
                        </label>
                    </form>
                </div>
                {{-- modal footer --}}
                <div class="flex items-center justify-end p-6 border-t border-solid border-gray-200 rounded-b">
                    <button
                        class="text-blue-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" onclick="toggleModal('Delete-Exam');clearInputs('deleteExam')">Close</button>

                    <button
                        class="bg-red-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2 rounded shadow
                    hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" onclick="promptDelete()">
                        Delete Exam
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        // A function for toggleling modals on and off along with the backdrop using modal id
        function toggleModal(modalID) {
            document.getElementById(modalID).classList.toggle("hidden");
            document.getElementById("backdrop").classList.toggle("hidden");
            document.getElementById(modalID).classList.toggle("flex");
            document.getElementById("backdrop").classList.toggle("flex");
        }

        function sortBy(column) {
            if (getQueryVariable(`${column}`) == -1) {
                window.location.replace(`{{ route('Schedule') }}?${column}=asc`);
            } else if (getQueryVariable(`${column}`) == 'asc') {
                window.location.replace(`{{ route('Schedule') }}?${column}=desc`);
            } else {
                window.location.replace("{{ route('Schedule') }}");
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

        function downloadPdf() {
            var count = {{ count($exams) }};
            for (i = 0; i < count; i++) {
                lab = document.getElementById('L-' + i);
                tutor = document.getElementById('I-' + i);
                if (lab != null && !lab.classList.contains('hidden')) {
                    lab.classList.add('hidden');
                }
                if (tutor != null && !tutor.classList.contains('hidden')) {
                    tutor.classList.add('hidden');
                }
            }
            var printContents = document.getElementById('table').innerHTML;
            var originalContents = document.body.innerHTML;

            document.body.innerHTML = printContents;

            window.print();

            document.body.innerHTML = originalContents;
        }
        // a function to clear forms on modal close
        function clearInputs(formName) {
            document.getElementById(formName).reset();
        }
        // a function that propmt the user if he wants to delete an exam
        function promptDelete() {
            if (confirm("Are you sure you want to delete the exam?") == true) {
                document.getElementById('deleteExam').submit();
            } else {}
        }

        //set values for edit exam -------- need editing
        function setValues(url, examId) {
            fetch(`${url}?id=${examId}`)
                .then(response => response.json())
                .then(data => {
                    // document.getElementById('course_code').value = data.course.course_code;
                });
        }

        //update exam invigilators on select from multi select
        function updateInvigilators(multi, url, examId) {
            var tutors = [],
                tutor, tutors_string = "";;
            var len = multi.options.length;
            var count = 0;
            var first = true;
            for (var i = 0; i < len; i++) {
                tutor = multi.options[i];
                if (tutor.selected) {
                    count++;
                }
            }
            for (var i = 0; i < len; i++) {
                tutor = multi.options[i];
                if (tutor.selected) {
                    count--;
                    tutors.push(tutor);
                    if (first) {
                        tutors_string += "&"
                        first = false;
                    }
                    if (count != 0) {
                        tutors_string += "tutors[]=" + tutor.value + "&";

                    } else {
                        tutors_string += "tutors[]=" + tutor.value;
                    }
                }

            }

            request_string = `${url}?id=${examId}${tutors_string}`;
            fetch(request_string, {
                    method: 'get',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(response => response.json())
                .then(data => {

                    var numberOfTutors = data.invigilators.length;
                    var invigilators = "";
                    if (numberOfTutors != 0) {
                        data.invigilators.forEach((invigilator, index) => {

                            invigilators +=
                                `<span id="E${examId}T${invigilator.tutor.tutor_id}" class='border-2 rounded-lg p-1 mr-1 leading-9 cursor-pointer'>`
                            invigilators += invigilator.tutor.tutor_name
                            invigilators += "</span>"

                        })
                    } else {
                        invigilators =
                            "<span class='border-2 border-yellow-200 rounded-lg p-1 mr-1 bg-yellow-100 hover:bg-yellow-200  leading-9 cursor-pointer'>" +
                            'No Invigilators are assigned for this exam' + "</span>";
                    }


                    document.getElementById(`PI-${examId}`).innerHTML = invigilators;
                })
                .catch((error) => {
                    console.error('Error:', error);
                });

            checkInvigilatorsConflicts();
        }

        //update exam labs on select from multi select
        function updateLabs(multi, url, examId) {
            var labs = [],
                lab, labs_string = "";;
            var len = multi.options.length;
            var count = 0;
            var first = true;
            for (var i = 0; i < len; i++) {
                lab = multi.options[i];
                if (lab.selected) {
                    count++;
                }
            }
            for (var i = 0; i < len; i++) {
                lab = multi.options[i];
                if (lab.selected) {
                    count--;
                    labs.push(lab);
                    if (first) {
                        labs_string += "&"
                        first = false;
                    }
                    if (count != 0) {
                        labs_string += "labs[]=" + lab.value + "&";

                    } else {
                        labs_string += "labs[]=" + lab.value;
                    }
                }

            }
            request_string = `${url}?id=${examId}${labs_string}`;
            fetch(request_string, {
                    method: 'get',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(response => response.json())
                .then(data => {

                    var numberOfLabs = data.labs.length;
                    var labsReserved = "";
                    if (numberOfLabs != 0) {
                        data.labs.forEach((lab, index) => {
                            labsReserved +=
                                `<span id="E${examId}L${lab.lab_id}" class='border-2 rounded-lg p-1 mr-1 leading-9 cursor-pointer'>`;
                            labsReserved += lab.labs.room;
                            labsReserved += "</span>";
                        })
                    } else {
                        labsReserved =
                            "<span class='border-2 border-yellow-200 rounded-lg p-1 mr-1 bg-yellow-100 hover:bg-yellow-200  leading-9 cursor-pointer'>" +
                            'No labs are assigned for this exam' + "</span>";
                    }


                    document.getElementById(`PL-${examId}`).innerHTML = labsReserved;
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
            checkLabsConflicts();
        }

        //show the mutliseelct for the specfic exam
        function showCheckboxes(id) {
            var checkboxes = document.getElementById(id);

            checkboxes.classList.toggle("hidden");
        }

        //allow multi selecting whithout clicking on CTRL
        $("select.multi").mousedown(function(e) {
            e.preventDefault();

            var select = this;
            var scroll = select.scrollTop;

            e.target.selected = !e.target.selected;

            setTimeout(function() {
                select.scrollTop = scroll;
            }, 0);

            $(select).focus();
        }).mousemove(function(e) {
            e.preventDefault()
        });

        //get start date and end date of the schedule from php
        var start_date_default = "{{ $setting->start_date ?? ' ' }}";
        var end_date_default = "{{ $setting->end_date ?? ' ' }}";
        //set the start date as the default passed from php
        function setDate() {
            document.getElementById('start_date').value = start_date_default;
        }
        //set values on page load
        $(document).ready(function() {
            setDate();
            checkLabsConflicts();
            checkInvigilatorsConflicts();
        });
        //if the date is changed and it's a sunday, update the start date and end date on the settings
        document.getElementById("start_date").onchange = function() {
            var date = new Date(this.value);
            var end = new Date();
            end.setDate(date.getDate() + 4);
            const start_date_const = date.getFullYear() + "-" + (date.getMonth() + 1) + "-" + date.getDate();
            const end_Date_const = end.getFullYear() + "-" + (end.getMonth() + 1) + "-" + end.getDate();
            console.log(date);
            if (date.getDay() != 0) {
                alert("A start date must be a sunday");
                this.value = start_date_default;
            } else {
                const data = {
                    start_date: start_date_const,
                    end_date: end_Date_const,
                };
                fetch("{{ route('updateSettings') }}", {
                        method: 'post', // or 'PUT'
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        body: JSON.stringify(data),
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log('Success:', data);
                        start_date_default = data.start_date;
                        end_date_default = data.end_date;
                    })
                    .catch((error) => {
                        console.error('Error:', error);
                        console.log(data);
                    });
            }
        };


        function checkLabsConflicts() {
            fetch("{{ route('getAllExamsLabs') }}", {
                    method: 'get',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    //Clear All
                    data.exams.forEach(exam => {
                        data.labs.forEach(lab => {
                            var labObject = document.getElementById(`E${exam.exam_id}L${lab.lab_id}`);
                            if (labObject != null) {
                                markClear(labObject);
                            }
                        });
                    });
                    numberOfExams = data.exams.length;
                    var examLabs = [];
                    var count = 0;
                    var conf = [];
                    var confExam = [];
                    data.exams.forEach((exam, index) => {
                        data.exams.forEach((eexam, eindex) => {
                            if (exam.exam_id != eexam.exam_id && exam.timeslot_id == eexam
                                .timeslot_id && exam.date == eexam.date) {
                                exam.labs.forEach(lab => {
                                    examLabs.push(lab.lab_id);
                                });
                                eexam.labs.forEach(lab => {
                                    examLabs.push(lab.lab_id);
                                });
                                findDuplicates(examLabs).forEach(conflict => {
                                    conf.push(conflict)
                                })
                                confExam.push(exam.exam_id);
                                confExam.push(eexam.exam_id);
                            }
                        });
                        examLabs = [];
                        conf = toUniqueArray(conf);
                        confExam = toUniqueArray(confExam);
                        confExam.forEach(exam_id => {
                            conf.forEach(lab_id => {
                                var labObject =
                                    document.getElementById(`E${exam_id}L${lab_id}`);
                                if (labObject != null) {
                                    markConflict(labObject);
                                }
                            });
                        });
                        conf = [];
                        confExam = [];
                    });
                    data.exams.forEach(exam => {
                        data.labs.forEach(lab => {
                            var labObject = document.getElementById(`E${exam.exam_id}L${lab.lab_id}`);
                            if (labObject != null) {
                                markClearAfter(labObject);
                            }
                        });
                    });
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }

        function checkInvigilatorsConflicts() {
            fetch("{{ route('getAllExamsTutors') }}", {
                    method: 'get',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                })
                .then(response => response.json())
                .then(data => {
                    //Clear All
                    data.exams.forEach(exam => {
                        data.tutors.forEach(tutor => {
                            var tutorObject = document.getElementById(
                                `E${exam.exam_id}T${tutor.tutor_id}`);
                            if (tutorObject != null) {
                                markClear(tutorObject);
                            }
                        });
                    });
                    numberOfExams = data.exams.length;
                    var examTutors = [];
                    var count = 0;
                    var conf = [];
                    var confExam = [];
                    data.exams.forEach((exam, index) => {
                        data.exams.forEach((eexam, eindex) => {
                            if (exam.exam_id != eexam.exam_id && exam.timeslot_id == eexam
                                .timeslot_id && exam.date == eexam.date) {
                                exam.tutors.forEach(tutor => {
                                    examTutors.push(tutor.tutor_id);
                                });
                                eexam.tutors.forEach(tutor => {
                                    examTutors.push(tutor.tutor_id);
                                });
                                findDuplicates(examTutors).forEach(conflict => {
                                    conf.push(conflict)
                                })
                                confExam.push(exam.exam_id);
                                confExam.push(eexam.exam_id);
                            }
                        });
                        examTutors = [];
                        conf = toUniqueArray(conf);
                        confExam = toUniqueArray(confExam);
                        confExam.forEach(exam_id => {
                            conf.forEach(tutor_id => {
                                var tutorObject =
                                    document.getElementById(`E${exam_id}T${tutor_id}`);
                                if (tutorObject != null) {
                                    markConflict(tutorObject);
                                }
                            });
                        });
                        conf = [];
                        confExam = [];
                    });
                    data.exams.forEach(exam => {
                        data.tutors.forEach(tutor => {
                            var tutorObject = document.getElementById(
                                `E${exam.exam_id}T${tutor.tutor_id}`);
                            if (tutorObject != null) {
                                markClearAfter(tutorObject);
                            }
                        });
                    });
                })
                .catch((error) => {
                    console.error('Error:', error);
                });
        }

        function isMarkedConflict(obj) {
            if (obj.classList.contains('bg-red-100')) {
                return true;
            } else {
                return false;
            }
        }

        function isMarkedClear(obj) {
            if (obj.classList.contains('bg-green-100')) {
                return true;
            } else {
                return false;
            }
        }

        function markConflict(obj) {
            if (!isMarkedConflict(obj)) {
                conflict(obj);
            }
            if (isMarkedClear(obj)) {
                notClear(obj);
            }
        }

        function markClear(obj) {
            if (!isMarkedClear(obj)) {
                clear(obj);
            }
            if (isMarkedConflict(obj)) {
                notConflict(obj);
            }
        }

        function markClearAfter(obj) {
            if (!isMarkedClear(obj) && !isMarkedConflict(obj)) {
                clear(obj);
            }
        }

        function conflict(obj) {
            obj.classList.add('border-red-200');
            obj.classList.add('bg-red-100');
            obj.classList.add('hover:bg-red-200');
        }

        function notConflict(obj) {
            obj.classList.remove('border-red-200');
            obj.classList.remove('bg-red-100');
            obj.classList.remove('hover:bg-red-200');
        }

        function clear(obj) {
            obj.classList.add('border-green-200');
            obj.classList.add('bg-green-100');
            obj.classList.add('hover:bg-green-200');
        }

        function notClear(obj) {
            obj.classList.remove('border-green-200');
            obj.classList.remove('bg-green-100');
            obj.classList.remove('hover:bg-green-200');
        }



        function findDuplicates(arr) {
            arr = arr.slice().sort();
            let results = [];
            for (let i = 0; i < arr.length - 1; i++) {
                if (arr[i + 1] == arr[i]) {
                    results.push(arr[i]);
                }
            }
            return results;
        }

        function toUniqueArray(arr) {
            var newArr = [];
            for (var i = 0; i < arr.length; i++) {
                if (newArr.indexOf(arr[i]) === -1) {
                    newArr.push(arr[i]);
                }
            }
            return newArr;
        }
    </script>

    <style>
        select.multi[multiple]:focus option:checked {
            background: linear-gradient(0deg, green 0%, green 100%);
        }

        thead {
            display: table-row-group;
        }

    </style>
@endsection
