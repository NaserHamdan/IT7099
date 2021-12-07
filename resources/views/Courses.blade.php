@extends('Layouts.app')
@section('title', 'Courses')
@section('content')
    {{-- backdrop for modals --}}
    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="backdrop"></div>
    {{-- button options --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-5 flex-row">
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                onclick="toggleModal('Add-Courses')">Add</button>
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                action="{{ Route('EditCourses') }}">Edit</button>
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                onclick="toggleModal('Delete-Course')">Delete</button>
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" onclick="event.preventDefault();
                document.getElementById('gatCourses').submit();">Get Courses</button>
                <form id="gatCourses" action="{{ route('LoadCourses') }}" method="GET" class="d-none">
                    @csrf
                </form>
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

    <script type="text/javascript">
        function toggleModal(modalID) {
            document.getElementById(modalID).classList.toggle("hidden");
            document.getElementById("backdrop").classList.toggle("hidden");
            document.getElementById(modalID).classList.toggle("flex");
            document.getElementById("backdrop").classList.toggle("flex");
        }

        function addFields() {
            var numberOfTutors = document.getElementById("numberOfTutors");

            if (numberOfTutors.value < 1) {
                numberOfTutors.value = 1;
            } else if (numberOfTutors.value > 6) {
                numberOfTutors.value = 6;
            }

            for (var i = 2; i <= 6; i++) {
                if (!document.getElementById("tutor" + i).classList.contains('hidden') && i > numberOfTutors.value) {
                    document.getElementById("tutor" + i).classList.toggle('hidden');
                    document.getElementById("select" + i).setAttribute("disabled", "disabled");
                } else if (document.getElementById("tutor" + i).classList.contains('hidden') && i <= numberOfTutors.value) {
                    document.getElementById("tutor" + i).classList.toggle("hidden");
                    document.getElementById("select" + i).removeAttribute("disabled");
                }
            }
        }

        function clearInputs(formName) {
            document.getElementById(formName).reset();
        }

        function promptDelete(){
            if (confirm("Are you sure you want to delete the course?") == true){
                document.getElementById('deleteCourse').submit();
            }else{

            }
        }
    </script>
@endsection
