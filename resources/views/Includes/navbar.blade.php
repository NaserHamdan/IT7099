<nav class="bg-red-600">

    <div class="max-w-screen-xl mx-auto px-2 sm:px-6 lg:px-8">
        <div class="relative flex items-center justify-between h-16">
            @auth
                <div class="absolute inset-y-0 left-0 flex items-center sm:hidden">
                    <!-- Mobile menu button-->
                    <button type="button"
                        class="inline-flex items-center justify-center p-2 rounded-md text-white hover:text-white hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white mobile-menu-button"
                        aria-controls="mobile-menu" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <!--
                      Icon when menu is closed.

                      Heroicon name: outline/menu

                      Menu open: "hidden", Menu closed: "block"
                    -->
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true" id="open">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <!--
                      Icon when menu is open.

                      Heroicon name: outline/x

                      Menu open: "block", Menu closed: "hidden"
                    -->
                        <svg class="hidden h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" aria-hidden="true" id="close">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            @endauth
            <div class="flex-1 flex items-center justify-center sm:items-stretch sm:justify-start">

                <div class="hidden sm:block sm:ml-6">
                    <div class="flex space-x-4">
                        <!-- Selected: "bg-red-900 text-white px-3 py-2 rounded-md text-sm font-medium" -->
                        @auth
                            <a href="#"
                                class="text-white hover:bg-red-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium"
                                href="{{ route('logout') }}"
                                onclick="event.preventDefault();
                                                      document.getElementById('logout-form').submit();">Hello, {{Auth::user()->name}}</a>
                            <a href="{{ route('Schedule') }}"
                                class="text-white hover:bg-red-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Schedule</a>

                            <a href="{{ route('Courses') }}"
                                class="text-white hover:bg-red-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Courses</a>

                            <a href="{{ route('Invigilators') }}"
                                class="text-white hover:bg-red-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Invigilators</a>

                            <a href="{{ route('Labs') }}"
                                class="text-white hover:bg-red-700 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Labs</a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        @endauth
                    </div>
                </div>
            </div>
            <div class="absolute inset-y-0 right-0 flex items-center pr-2 sm:static sm:inset-auto sm:ml-6 sm:pr-0">

                <!-- Profile dropdown -->
                <div class="ml-3 relative">
                    <div>
                        <div class="flex-shrink-0 flex items-center">
                            <img class="block lg:hidden h-12 w-auto"
                                src="assets/images/Logo-square.png" alt="Bahrain Polytechnic">
                            <img class="hidden lg:block h-12 w-auto"
                                src="assets/images/Logo-Line.png"
                                alt="Bahrain Polytechnic">
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Mobile menu, show/hide based on menu state. -->
    @auth
        <div class="hidden sm:hidden" id="mobile-menu">
            <div class="px-2 pt-2 pb-3 space-y-1">
                <!-- selected: "bg-red-900 text-white block px-3 py-2 rounded-md text-base font-medium" -->
                <a href="{{ route('Schedule') }}"
                    class="text-white hover:bg-red-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Schedule</a>

                <a href="{{ route('Courses') }}"
                    class="text-white hover:bg-red-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Courses</a>

                <a href="{{ route('Invigilators') }}"
                    class="text-white hover:bg-red-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Invigilators</a>

                <a href="{{ route('Labs') }}"
                    class="text-white hover:bg-red-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium">Labs</a>
                <a href="#"
                    class="text-white hover:bg-red-700 hover:text-white block px-3 py-2 rounded-md text-base font-medium"
                    href="{{ route('logout') }}" onclick="event.preventDefault();
                                      document.getElementById('logout-form').submit();">{{ __('Log out') }}</a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>
            </div>
        </div>
    @endauth
    <script>
        // Grab HTML Elements
        const btn = document.querySelector("button.mobile-menu-button");
        const menu = document.querySelector("#mobile-menu");
        const open = document.querySelector("#open");
        const close = document.querySelector("#close");

        // Add Event Listeners
        btn.addEventListener("click", () => {
            menu.classList.toggle("hidden");
            open.classList.toggle("hidden");
            close.classList.toggle("hidden");
        });
    </script>
</nav>
