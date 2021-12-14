@extends('Layouts.app')
@section('title', 'Schedule')
@section('content')
    {{-- backdrop for modals --}}
    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="backdrop"></div>
    {{-- button options --}}
    <div class="max-w-fit mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-5 flex-row">
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                onclick="toggleModal('Add-Exam')">Add</button>
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                onclick="toggleModal('Edit-Exam')">Edit</button>
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                onclick="toggleModal('Delete-Exam')">Delete</button>
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" onclick="">Generate
                Timetable</button>
            <label class="bg-gray-500 text-white font-bold p-0 m-0 py-2 px-4 rounded" for="start_date">Start Date</label>
            <input id="start_date" value="{{ $setting->start_date ?? ' ' }}" name="start_date" min="{{ date('Y-m-d') }}"
                type="date" class="form-input font-bold py-2 px-4 rounded" required />
        </div>
        {{-- courses table --}}
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
                                <tr>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $exam->course->year->number }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4whitespace-nowrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">
                                            {{ $exam->course->major->major_name }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">
                                            {{ $exam->course->course_code . ' - ' . $exam->course->course_title }}</div>
                                    </td>
                                    <td class="px-6 py-4 border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">
                                            {{ date('l d/m/Y', strtotime($exam->date)) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">
                                            {{ date('H:i', strtotime($exam->timeslot->start_time)) . ' - ' . date('H:i', strtotime($exam->timeslot->end_time)) }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ count($exam->labs) }}</div>
                                    </td>
                                    <td class="px-6 py-4 h-auto w-1/4 whitespace-normal border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">
                                            @php
                                                $index++;
                                            @endphp
                                            <p class="p-0 m-0" id="P-{{ $exam->exam_id }}"
                                                onclick="showCheckboxes('I-{{ $index }}')">
                                                @php
                                                    $length = count($exam->tutors);
                                                @endphp
                                                @if (count($exam->tutors) == 0)
                                                    <span
                                                        class='border-2 border-yellow-200 rounded-lg p-1 mr-1 bg-yellow-100 hover:bg-yellow-200 leading-9'>
                                                        {{ 'No Invigilators are assigned for this exam' }}
                                                    </span>
                                                @else
                                                    @foreach ($exam->tutors as $i => $tutor)
                                                        <span
                                                            class='border-2 border-green-200 rounded-lg p-1 mr-1 bg-green-100 hover:bg-green-200 leading-9'>
                                                            {{-- @if ($i < $length - 1) --}}

                                                            {{-- {{ $tutor->tutor_name . ' - ' }} --}}

                                                            {{-- @else --}}
                                                            {{ $tutor->tutor_name }}
                                                            {{-- @endif --}}
                                                        </span>
                                                    @endforeach
                                                @endif
                                                <br>

                                            </p>
                                            <div id="I-{{ $index }}" class=" hidden mt-2">
                                                <select id="multi" name="tutors[]"
                                                    onclick="updateInvigilators(this,'{{ route('updateInvigilators') }}', '{{ $exam->exam_id }}', this.value,'{{ $index }}');"
                                                    class="form-multiselect multi block w-full mt-1" multiple>
                                                    @foreach ($tutors as $tutor)
                                                        <option class="checked:bg-green-300 "
                                                            value="{{ $tutor->tutor_id }}"
                                                            @foreach ($exam->invigilations as $invigilation)
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
        function toggleModal(modalID) {
            document.getElementById(modalID).classList.toggle("hidden");
            document.getElementById("backdrop").classList.toggle("hidden");
            document.getElementById(modalID).classList.toggle("flex");
            document.getElementById("backdrop").classList.toggle("flex");
        }

        function clearInputs(formName) {
            document.getElementById(formName).reset();
        }

        function promptDelete() {
            if (confirm("Are you sure you want to delete the exam?") == true) {
                document.getElementById('deleteExam').submit();
            } else {

            }
        }

        function setValues(url, examId) {
            fetch(`${url}?id=${examId}`)
                .then(response => response.json())
                .then(data => {
                    // document.getElementById('course_code').value = data.course.course_code;
                });
        }


        //
        function updateInvigilators(multi, url, examId, tutors, index) {
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
            // const data = {
            //         start_date: start_date_const,
            //         end_date: end_Date_const,
            //     };
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
                    console.log(numberOfTutors);
                    var invigilators = "";
                    if (numberOfTutors != 0) {
                        data.invigilators.forEach((invigilator, index) => {
                            // if (index < (numberOfTutors - 1)) {
                            //     invigilators += invigilator.tutor.tutor_name + " - ";
                            // } else {
                            invigilators +=
                                `<span id="E${examId}T${invigilator.tutor.tutor_id}" class='border-2 border-green-200 rounded-lg p-1 mr-1 bg-green-100 hover:bg-green-200 leading-9'>`
                            invigilators += invigilator.tutor.tutor_name
                            invigilators += "</span>"
                            // }
                        })
                    } else {
                        invigilators =
                            "<span class='border-2 border-yellow-200 rounded-lg p-1 mr-1 bg-yellow-100 hover:bg-yellow-200  leading-9'>" +
                            'No Invigilators are assigned for this exam' + "</span>";
                    }


                    document.getElementById(`P-${examId}`).innerHTML = invigilators;
                })
                .catch((error) => {
                    console.error('Error:', error);
                });

        }

        function showCheckboxes(id) {
            var checkboxes = document.getElementById(id);

            checkboxes.classList.toggle("hidden");
        }

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

        var start_date_default = "{{ $setting->start_date }}";
        var end_date_default = "{{ $setting->end_date }}";
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
    </script>

    <style>
        select.multi[multiple]:focus option:checked {
            background: linear-gradient(0deg, green 0%, green 100%);
        }

    </style>
@endsection
