@extends('layouts.app')
@section('title', 'Labs')
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
                $labs = $labs->sortby($column);
            } elseif ($_GET[$column] == 'desc') {
                $labs = $labs->sortByDesc($column);
            }
        }
    }

    @endphp
    {{-- backdrop for modals --}}
    <div class="hidden opacity-25 fixed inset-0 z-40 bg-black" id="backdrop"></div>

    <div class="max-w-fit mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center gap-3 flex-row">
            @if (Auth::user()->admin == 1)
                <button
                    class="text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-m px-4 py-2.5 text-center inline-flex items-center"
                    onclick="toggleModal('Add-Lab')">Add</button>
                <button
                    class="text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-m px-4 py-2.5 text-center inline-flex items-center"
                    onclick="toggleModal('Edit-Lab')">Edit</button>
                <button
                    class="text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-m px-4 py-2.5 text-center inline-flex items-center"
                    onclick="toggleModal('Delete-Lab')">Delete</button>
                <button
                    class="text-white bg-gray-500 hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-m px-4 py-2.5 text-center inline-flex items-center"
                    onclick="promptGetLabs()">Get Labs</button>
                <form id="gatLabs" action="{{ route('LoadLabs') }}" method="GET" class="d-none">
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
                                href="#" onclick="sortBy('room')">Room</a>
                        </li>
                        <li>
                            <a class="dropdown-item text-sm py-2 px-4 font-normal block w-full whitespace-nowrap bg-transparent text-white hover:bg-gray-100"
                                href="#" onclick="sortBy('building')">Building</a>
                        </li>
                    </ul>
                </div>
            </div>

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
                                    Room</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Building</th>

                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Number of Assignments</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    Max Capicity</th>
                                <th
                                    class="px-6 py-3 text-xs font-medium leading-4 tracking-wider text-left text-gray-500 uppercase border-b border-gray-200 bg-gray-50">
                                    available capacity</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white">
                            @foreach ($labs as $lab)
                                <tr>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $lab->room }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $lab->building }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ count($lab->exams_labs) }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $lab->max_capacity }}</div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-no-wrap border-b border-gray-200">
                                        <div class="text-sm leading-5 text-gray-500">{{ $lab->available_capacity }}
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
    @if (Auth::user()->admin == 1)
        {{-- Add lab Modal --}}
        <div class=" hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
            id="Add-Lab">
            <div class="relative w-auto my-6 mx-auto max-w-none">
                <div
                    class=" border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                    {{-- modal header --}}
                    <div class="flex items-start p-5 border-b border-solid border-gray-200 rounded-t">
                        <h3 class="text-3xl font-semibold">Add a new Lab</h3>
                    </div>
                    {{-- modal body --}}
                    <div class="flex flex-col relative p-6  justify-between text-left ">
                        <form name='addLab' id='addLab' action=" {{ route('addLab') }}" method="post">
                            @csrf
                            <label class="block">
                                <span class="text-gray-700">Lab room</span>
                                <input name="room" class="form-input mt-1 block w-full" placeholder="36.124" required />
                            </label>

                            <label class="block">
                                <span class="text-gray-700">Building</span>
                                <input name="building" class="form-input mt-1 block w-full" placeholder="BLDG36" required />
                            </label>

                            <label class="block">
                                <span class="text-gray-700">Max Capacity</span>
                                <input name="max_capacity" type="number" class="form-input mt-1 block w-full"
                                    placeholder="20" required />
                            </label>

                            <label class="block">
                                <span class="text-gray-700">Available capacity</span>
                                <input name="available_capacity" type="number" class="form-input mt-1 block w-full"
                                    placeholder="15" required />
                            </label>

                            <label class="hidden">
                                <input name="reviewed" type='number' value='1' class="form-input mt-1 block w-full"
                                    required />
                            </label>
                        </form>
                    </div>
                    {{-- modal footer --}}
                    <div class="flex items-center justify-end p-6 border-t border-solid border-gray-200 rounded-b">
                        <button
                            class="text-blue-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="button" onclick="toggleModal('Add-Lab');clearInputs('addLab')">Close</button>

                        <button
                            class="bg-blue-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2 rounded shadow
            hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="submit" form='addlab'>
                            Add Lab
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Edit lab Modal --}}
        <div class=" hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
            id="Edit-Lab">
            <div class="relative w-auto my-6 mx-auto max-w-none">
                <div
                    class=" border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                    {{-- modal header --}}
                    <div class="flex items-start p-5 border-b border-solid border-gray-200 rounded-t">
                        <h3 class="text-3xl font-semibold">Edit a Lab</h3>
                    </div>
                    {{-- modal body --}}
                    <div class="flex flex-col relative p-6  justify-between text-left ">
                        <form name='editLab' id='editLab' action="  {{ route('editLab') }} " method="post">
                            @csrf
                            <label class="block mt-4 ">
                                <span class="text-gray-700">Room</span>
                                <select onchange="setValues('{{ route('fetchLabData') }}',this.value)" name="lab_id"
                                    class="form-select mt-1 block w-full">
                                    @foreach ($labs as $lab)
                                        <option value="{{ $lab->lab_id }}">{{ $lab->room }}</option>
                                    @endforeach
                                </select>
                            </label>
                            <label class="block">
                                <span class="text-gray-700">Lab room</span>
                                <input id="room" name="room" class="form-input mt-1 block w-full" value=""
                                    placeholder="36.124" required />
                            </label>

                            <label class="block">
                                <span class="text-gray-700">Building</span>
                                <input id="building" name="building" class="form-input mt-1 block w-full" value=""
                                    placeholder="BLDG36" required />
                            </label>

                            <label class="block">
                                <span class="text-gray-700">Max Capacity</span>
                                <input id="max_capacity" name="max_capacity" type="number"
                                    class="form-input mt-1 block w-full" value="" placeholder="20" required />
                            </label>

                            <label class="block">
                                <span class="text-gray-700">Available capacity</span>
                                <input id="available_capacity" name="available_capacity" type="number"
                                    class="form-input mt-1 block w-full" placeholder="15" required />
                            </label>

                            <label class="hidden">
                                <input name="reviewed" type='number' value='1' class="form-input mt-1 block w-full"
                                    required />
                            </label>
                        </form>
                    </div>
                    {{-- modal footer --}}
                    <div class="flex items-center justify-end p-6 border-t border-solid border-gray-200 rounded-b">
                        <button
                            class="text-blue-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="button" onclick="toggleModal('Edit-Lab');clearInputs('editLab')">Close</button>

                        <button
                            class="bg-blue-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2
                        rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="submit" form="editLab">
                            Edit Lab
                        </button>
                    </div>
                </div>
            </div>
        </div>

        {{-- Delete Lab Modal --}}
        <div class=" hidden overflow-x-hidden overflow-y-auto fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
            id="Delete-Lab">
            <div class="relative w-auto my-6 mx-auto max-w-none">
                <div
                    class=" border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                    {{-- modal header --}}
                    <div class="flex items-start p-5 border-b border-solid border-gray-200 rounded-t">
                        <h3 class="text-3xl font-semibold">Delete a lab</h3>
                    </div>
                    {{-- modal body --}}
                    <div class="flex flex-row relative p-6  justify-between text-left ">
                        <form name='deleteLab' id='deleteLab' action=" {{ route('deleteLab') }}" method="post">
                            @csrf
                            <label class="block mt-4 ">
                                <span class="text-gray-700">Room</span>
                                <select name="lab_id" class="form-select mt-1 block w-full">
                                    @foreach ($labs as $lab)
                                        <option value="{{ $lab->lab_id }}">{{ $lab->room }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </form>
                    </div>
                    {{-- modal footer --}}
                    <div class="flex items-center justify-end p-6 border-t border-solid border-gray-200 rounded-b">
                        <button
                            class="text-blue-500 background-transparent font-bold uppercase px-6 py-2 text-sm outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="button" onclick="toggleModal('Delete-Lab');clearInputs('deleteLab')">Close</button>

                        <button
                            class="bg-red-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2 rounded shadow
                    hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="button" onclick="promptDelete()">
                            Delete Lab
                        </button>
                    </div>
                </div>
            </div>
        </div>



        {{-- Review lab Modal --}}
        <div class=" hidden overflow-x-hidden overflow-y-auto mt-10 fixed inset-0 z-50 outline-none focus:outline-none justify-center items-center"
            id="Review-Lab">
            <div class="relative w-auto my-auto mx-auto max-w-none">
                <div
                    class=" border-0 rounded-lg shadow-lg relative flex flex-col w-full bg-white outline-none focus:outline-none">
                    {{-- modal header --}}
                    <div class="flex items-start p-5 border-b border-solid border-gray-200 rounded-t">
                        <h3 class="text-3xl font-semibold">Review Labs</h3>
                    </div>
                    {{-- modal body --}}
                    <div class="flex flex-col relative p-6  justify-between text-left ">
                        <form name='reviewLab' id='reviewLab' action="{{ route('updateLabs') }}" method="post">
                            @csrf
                            @php
                                $index = 1;
                            @endphp
                            @foreach ($labs as $lab)
                                @if ($lab->reviewed == 0)
                                    <h6 class="font-semibold">Lab {{ $index }}</h6>
                                    <input type="hidden" name="lab_id{{ $index }}" value="{{ $lab->lab_id }}" />
                                    <label class="block">
                                        <span class="text-gray-700">Lab room</span>
                                        <input name="room{{ $index }}" class="form-input mt-1 block w-full"
                                            placeholder="36.124" value="{{ $lab->room }}" required />
                                    </label>

                                    <label class="block">
                                        <span class="text-gray-700">Building</span>
                                        <input name="building{{ $index }}" class="form-input mt-1 block w-full"
                                            placeholder="BLDG36" value="{{ $lab->building }}" required />
                                    </label>

                                    <label class="block">
                                        <span class="text-gray-700">Max Capacity</span>
                                        <input name="max_capacity{{ $index }}" type="number"
                                            class="form-input mt-1 block w-full" value="{{ $lab->max_capacity }}"
                                            placeholder="20" required />
                                    </label>

                                    <label class="block">
                                        <span class="text-gray-700">Available capacity</span>
                                        <input name="available_capacity{{ $index }}" type="number"
                                            class="form-input mt-1 block w-full" value="{{ $lab->available_capacity }}"
                                            placeholder="15" required />
                                    </label>
                                    <hr />
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
                            type="button" onclick="toggleModal('Review-Lab');clearInputs('reviewLab')">Close</button>

                        <button
                            class="bg-blue-500 text-white active:bg-purple-600 font-bold uppercase text-xs px-4 py-2 rounded shadow
            hover:shadow-md outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                            type="submit" form='reviewLab'>
                            Confirm Labs
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif

    <script type="text/javascript">
        function sortBy(column) {
            if (getQueryVariable(`${column}`) == -1) {
                window.location.replace(`{{ route('Labs') }}?${column}=asc`);
            } else if (getQueryVariable(`${column}`) == 'asc') {
                window.location.replace(`{{ route('Labs') }}?${column}=desc`);
            } else {
                window.location.replace("{{ route('Labs') }}");
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
        @if (Auth::user()->admin == 1)
            function toggleModal(modalID) {
            document.getElementById(modalID).classList.toggle("hidden");
            document.getElementById("backdrop").classList.toggle("hidden");
            document.getElementById(modalID).classList.toggle("flex");
            document.getElementById("backdrop").classList.toggle("flex");
            }
            //set values on page load
            $(document).ready(function() {
            @if (Auth::user()->admin == 1)
                var count = {{ $count }};
                if (count > 0) {
                toggleModal('Review-Lab');
                }
            @endif
            });

            function clearInputs(formName) {
            document.getElementById(formName).reset();
            }

            function promptDelete() {
            if (confirm("Are you sure you want to delete the lab?") == true) {
            document.getElementById('deleteLab').submit();
            } else {

            }
            }

            function promptGetLabs() {
            if (confirm("Are you sure you want to get all unregistred labs from the database ?") == true) {
            event.preventDefault();
            document.getElementById('gatLabs').submit();
            } else {

            }
            }

            function setValues(url, labId) {
            fetch(`${url}?id=${labId}`)
            .then(response => response.json())
            .then(data => {
            document.getElementById('room').value = data.lab.room;
            document.getElementById('building').value = data.lab.building;
            document.getElementById('max_capacity').value = data.lab.max_capacity;
            document.getElementById('available_capacity').value = data.lab.available_capacity;
            });
            }
        @endif
    </script>
@endsection
