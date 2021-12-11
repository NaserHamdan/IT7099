@extends('Layouts.app')
@section('title', 'Schedule')
@section('content')
    {{-- backdrop for modals --}}
    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="backdrop"></div>
    {{-- button options --}}
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-5 flex-row">
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                onclick="toggleModal('Add-Exam')">Add</button>
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                onclick="toggleModal('Edit-Exam')">Edit</button>
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                onclick="toggleModal('Delete-Exam')">Delete</button>
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded" onclick="">Generate
                Timetable</button>
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
                            @foreach ($exams as $exam)
                                <tr>

                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ 0 }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ 0 }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ 0 }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ 0 }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ 0 }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ 0 }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ 0 }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ 0 }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        0
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
                    <form name='addExam' id='addExam' action="" method="post">
                        @csrf
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
                    <form name='deleteExam' id='deleteExam' action="" method="post">
                        @csrf
                        <label class="block mt-4">
                            <span class="text-gray-700">Exam</span>
                            <select name="exam_id" class="form-select mt-1 block w-full">
                                @foreach ($exams as $exam)
                                    <option value="{{ $exam->exam_id }}">
                                        {{ 0 }}</option>
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
                document.getElementById('deleteCourse').submit();
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
    </script>
@endsection
