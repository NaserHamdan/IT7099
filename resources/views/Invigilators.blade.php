@extends('Layouts.app')
@section('title', 'Invigilators')
@section('content')
    {{-- backdrop for modals --}}
    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="backdrop"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-5 flex-row">
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                onclick="toggleModal('Add-Tutor')">Add</button>
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                onclick="toggleModal('Edit-Tutor')">Edit</button>
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                onclick="toggleModal('Delete-Tutor')">Delete</button>
            <button class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded"
                onclick="promptGetTutors()">Get Tutors</button>
            <form id="gatTutors" action="{{ route('LoadTutors') }}" method="GET" class="d-none">
                @csrf
            </form>
        </div>

        <div class="flex flex-col mt-8">
            <div class="py-2 -my-2 overflow-x-auto sm:-mx-6 sm:px-6 lg:-mx-8 lg:px-8">
                <div
                    class="inline-block min-w-full overflow-hidden align-middle border-b border-gray-200 shadow sm:rounded-lg">
                    <table class="min-w-full">
                        <thead>
                            <tr>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Invigilator Name</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Static Invigilations</th>

                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Floating Invigilations</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Total invigilations</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($tutors as $tutor)
                                <tr>
                                    @php
                                        $total = 0;
                                        $F = 0;
                                        $S = 0;
                                        foreach ($tutor->invigilations as $invigilation) {
                                            if ($invigilation->invigilation_type == 'F') {
                                                $F = $F + 1;
                                            } elseif ($invigilation->invigilation_type == 'S') {
                                                $S = $S + 1;
                                            }
                                            $total += 1;
                                        }
                                    @endphp
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $tutor->tutor_name }}
                                            @php
                                                $position = explode(' ', $tutor->position);
                                                if (count($position) >= 2) {
                                                    $positionInitials = strtoupper(substr($position[0], 0, 1) . substr(end($position), 0, 1));
                                                } else {
                                                    preg_match_all('#([A-Z]+)#', $tutor->position, $capitals);
                                                    if (count($capitals[1]) >= 2) {
                                                        $positionInitials = substr(implode('', $capitals[1]), 0, 2);
                                                    } else {
                                                        $positionInitials = strtoupper(substr($tutor->position, 0, 1));
                                                    }
                                                }

                                            @endphp
                                            {{ '(' . $positionInitials . ')' }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $S }}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $F }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $total }}</div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    {{-- Add tutor Modal --}}
    <div class=" hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
        id="Add-Tutor">
        <div class="relative w-auto my-6 mx-auto max-w-none">
            <div
                class=" border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                {{-- modal header --}}
                <div class="flex items-start p-5 border-b border-solid border-gray-200 rounded-t">
                    <h3 class="text-3xl font-semibold">Add a new Tutor</h3>
                </div>
                {{-- modal body --}}
                <div class="flex flex-col relative p-6  justify-between text-left ">
                    <form name='addTutor' id='addTutor' action=" {{ route('addTutor') }}" method="post">
                        @csrf
                        <label class="block">
                            <span class="text-gray-700">Tutor Name</span>
                            <input name="tutor_name" class="form-input mt-1 block w-full" placeholder="Naser Hamdan"
                                required />
                        </label>

                        <label class="block mt-4">
                            <span class="text-gray-700">Position</span>
                            <select name="position" class="form-select mt-1 block w-full">
                                {{-- <option>Select Marking Diffucality</option> --}}
                                <option>Tutor</option>
                                <option>Programme Manager</option>
                            </select>
                        </label>
                        <label class="hidden">
                            <input name="reviewed" type='number' value='1' class="form-input mt-1 block w-full" required />
                        </label>
                    </form>
                </div>
                {{-- modal footer --}}
                <div class="flex items-center justify-end p-6 border-t border-solid border-gray-200 rounded-b">
                    <button
                        class="text-blue-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" onclick="toggleModal('Add-Tutor');clearInputs('addTutor')">Close</button>

                    <button
                        class="bg-blue-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2 rounded shadow
            hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="submit" form='addtutor'>
                        Add Tutor
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Edit Tutor Modal --}}
    <div class=" hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
        id="Edit-Tutor">
        <div class="relative w-auto my-6 mx-auto max-w-none">
            <div
                class=" border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                {{-- modal header --}}
                <div class="flex items-start p-5 border-b border-solid border-gray-200 rounded-t">
                    <h3 class="text-3xl font-semibold">Edit a Tutor</h3>
                </div>
                {{-- modal body --}}
                <div class="flex flex-col relative p-6  justify-between text-left ">
                    <form name='editTutor' id='editTutor' action="  {{ route('editTutor') }} " method="post">
                        @csrf
                        <label class="block mt-4 ">
                            <span class="text-gray-700">Tutor</span>
                            <select id="tutor_id" onchange="setValues('{{ route('fetchTutorData') }}',this.value)" name="tutor_id"
                                class="form-select mt-1 block w-full">
                                @foreach ($tutors as $tutor)
                                    <option value="{{ $tutor->tutor_id }}">{{ $tutor->tutor_name }}</option>
                                @endforeach
                            </select>
                        </label>
                        <label class="block">
                            <span class="text-gray-700">Tutor Name</span>
                            <input id="tutor_name" name="tutor_name" class="form-input mt-1 block w-full" placeholder="Naser Hamdan"
                                required />
                        </label>

                        <label class="block mt-4">
                            <span class="text-gray-700">Position</span>
                            <select id="position" name="position" class="form-select mt-1 block w-full">
                                <option value="Tutor">Tutor</option>
                                <option value="Programme Manager">Programme Manager</option>
                                <option value="undefined">Undefined</option>
                            </select>
                        </label>

                        <label class="hidden">
                            <input name="reviewed" type='number' value='1' class="form-input mt-1 block w-full" required />
                        </label>
                    </form>
                </div>
                {{-- modal footer --}}
                <div class="flex items-center justify-end p-6 border-t border-solid border-gray-200 rounded-b">
                    <button
                        class="text-blue-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" onclick="toggleModal('Edit-Tutor');clearInputs('editTutor')">Close</button>

                    <button
                        class="bg-blue-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2
                rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="submit" form="editTutor">
                        Edit Tutor
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- Delete Tutor Modal --}}
    <div class=" hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
        id="Delete-Tutor">
        <div class="relative w-auto my-6 mx-auto max-w-none">
            <div
                class=" border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                {{-- modal header --}}
                <div class="flex items-start p-5 border-b border-solid border-gray-200 rounded-t">
                    <h3 class="text-3xl font-semibold">Delete a tutor</h3>
                </div>
                {{-- modal body --}}
                <div class="flex flex-row relative p-6  justify-between text-left ">
                    <form name='deleteTutor' id='deleteTutor' action=" {{ route('deleteTutor') }}" method="post">
                        @csrf
                        <label class="block mt-4">
                            <span class="text-gray-700">Tutor Name</span>
                            <select name="tutor_id" class="form-select mt-1 block w-full">
                                @foreach ($tutors as $tutor)
                                    <option value="{{ $tutor->tutor_id }}">
                                        {{ $tutor->tutor_name }}</option>
                                @endforeach
                            </select>
                        </label>
                    </form>
                </div>
                {{-- modal footer --}}
                <div class="flex items-center justify-end p-6 border-t border-solid border-gray-200 rounded-b">
                    <button
                        class="text-blue-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" onclick="toggleModal('Delete-Tutor');clearInputs('deleteTutor')">Close</button>

                    <button
                        class="bg-red-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2 rounded shadow
                    hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                        type="button" onclick="promptDelete()">
                        Delete Tutor
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
            if (confirm("Are you sure you want to delete the tutor?") == true) {
                document.getElementById('deleteTutor').submit();
            } else {

            }
        }

        function promptGetTutors() {
            if (confirm("Are you sure you want to get all unregistred tutors from the database ?") == true) {
                event.preventDefault();
                document.getElementById('gatTutors').submit();
            } else {

            }
        }

        function setValues(url, tutorId) {
            fetch(`${url}?id=${tutorId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('tutor_name').value = data.tutor.tutor_name;
                    document.getElementById('position').value = data.tutor.position;
                });
        }
    </script>
@endsection
