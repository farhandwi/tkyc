<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])


    <!-- Include jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.tailwindcss.css" />

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>



    <link rel="icon" href="/assets/images/favicon-tugu.png" type="image/x-icon">

    <link rel="stylesheet" href="https://rsms.me/inter/inter.css">


    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
</head>
</head>

<body>
    <div>
        <div>
            <div class="relative z-50 lg:hidden hidden" role="dialog" aria-modal="true">
                <div class="fixed inset-0 bg-gray-900/80" aria-hidden="true"></div>

                <div class="fixed inset-0 flex">
                    <div class="relative mr-16 flex w-full max-w-xs flex-1">
                        <div class="absolute left-full top-0 flex w-16 justify-center pt-5">
                            <button type="button" class="-m-2.5 p-2.5">
                                <span class="sr-only">Close sidebar</span>
                                <svg class="size-6 text-white" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor" aria-hidden="true" data-slot="icon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>

                        <div class="flex grow flex-col gap-y-5 overflow-y-auto bg-white px-6 pb-2">
                            <div class="flex h-16 shrink-0 items-center">
                                <img class="h-8 w-auto" src="{{ asset('images/logo-tugu.png') }}" alt="Your Company">
                            </div>
                            <nav class="flex flex-1 flex-col">
                                <ul role="list" class="flex flex-1 flex-col gap-y-7">
                                    <li>
                                        <ul role="list" class="-mx-2 space-y-1">
                                            <li>
                                                <a href="{{ route('home') }}"
                                                    class="group flex gap-x-3 rounded-md bg-gray-50 p-2 text-sm/6 font-semibold text-indigo-600">
                                                    <svg class="size-6 shrink-0 text-indigo-600" fill="none"
                                                        viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                                        aria-hidden="true" data-slot="icon">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                                    </svg>
                                                    Dashboard
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('employee') }}"
                                                    class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                                                    <svg class="size-6 shrink-0 text-gray-400 group-hover:text-indigo-600"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                                    </svg>
                                                    Employee
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('title') }}"
                                                    class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                                                    <svg class="size-6 shrink-0 text-gray-400 group-hover:text-indigo-600"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                                    </svg>
                                                    Title
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('application') }}"
                                                    class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                                                    <svg class="size-6 shrink-0 text-gray-400 group-hover:text-indigo-600"
                                                        fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                        stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                                    </svg>
                                                    Application
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                    <li>
                                        <div class="text-xs/6 font-semibold text-gray-400">Cost Center Overview</div>
                                        <ul role="list" class="-mx-2 mt-2 space-y-1">
                                            <li>
                                                <a href="{{ route('costCenter') }}"
                                                    class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                                                    <span
                                                        class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-white text-[0.625rem] font-medium text-gray-400 group-hover:border-indigo-600 group-hover:text-indigo-600">C</span>
                                                    <span class="truncate">Cost
                                                        Center</span>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{ route('costCenterHierarchy') }}"
                                                    class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold text-gray-700 hover:bg-gray-50 hover:text-indigo-600">
                                                    <span
                                                        class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-white text-[0.625rem] font-medium text-gray-400 group-hover:border-indigo-600 group-hover:text-indigo-600">H</span>
                                                    <span class="truncate">Cost
                                                        Center Heirarchy</span>
                                                </a>
                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Static sidebar for desktop -->
            <div class="hidden lg:fixed lg:inset-y-0 lg:z-50 lg:flex lg:w-72 lg:flex-col">
                <!-- Sidebar component, swap this element with another sidebar if you like -->
                <div class="flex grow flex-col gap-y-5 overflow-y-auto border-r border-gray-200 px-6 ">
                    <div class="flex h-16 shrink-0 items-center">
                        <img class="h-8 w-auto" src="{{ asset('images/logo-tugu.png') }}" alt="Your Company">
                    </div>
                    <nav class="flex flex-1 flex-col">
                        <ul role="list" class="flex flex-1 flex-col gap-y-7">
                            <li>
                                <ul role="list" class="-mx-2 space-y-1">
                                    <li>
                                        <!-- Current: "bg-gray-50 text-indigo-600", Default: "text-gray-700 hover:text-indigo-600 hover:bg-gray-50" -->
                                        <a href="{{ route('home') }}"
                                            class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold
                                      {{ request()->is('tkyc/home') ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                                            <svg class="size-6 shrink-0
                                    {{ request()->is('tkyc/home') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                                            </svg>
                                            Dashboard
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('employee') }}"
                                            class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold {{ request()->is('tkyc/employee*') ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                                            <svg class="size-6 shrink-0
                                    {{ request()->is('tkyc/employee*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                            </svg>
                                            Employee
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('title') }}"
                                            class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold {{ request()->is('tkyc/title*') ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                                            <svg class="size-6 shrink-0
                                    {{ request()->is('tkyc/title*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                            </svg>
                                            Title
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('application') }}"
                                            class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold {{ request()->is('tkyc/application*') ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                                            <svg class="size-6 shrink-0 {{ request()->is('tkyc/application*') ? 'text-indigo-600' : 'text-gray-400 group-hover:text-indigo-600' }}"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                stroke="currentColor" aria-hidden="true" data-slot="icon">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M15.75 17.25v3.375c0 .621-.504 1.125-1.125 1.125h-9.75a1.125 1.125 0 0 1-1.125-1.125V7.875c0-.621.504-1.125 1.125-1.125H6.75a9.06 9.06 0 0 1 1.5.124m7.5 10.376h3.375c.621 0 1.125-.504 1.125-1.125V11.25c0-4.46-3.243-8.161-7.5-8.876a9.06 9.06 0 0 0-1.5-.124H9.375c-.621 0-1.125.504-1.125 1.125v3.5m7.5 10.375H9.375a1.125 1.125 0 0 1-1.125-1.125v-9.25m12 6.625v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H9.75" />
                                            </svg>
                                            Application
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li>
                                <div class="text-xs/6 font-semibold text-gray-400">Cost Center Overview</div>
                                <ul role="list" class="-mx-2 mt-2 space-y-1">
                                    <li>
                                        <a href="{{ route('costCenter') }}"
                                            class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold {{ request()->is('tkyc/costcenter') || request()->is('costcenter/*') ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                                            <span
                                                class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-white text-[0.625rem] font-medium {{ request()->is('tkyc/costcenter') || request()->is('costcenter/*') ? 'text-indigo-600 border-indigo-600' : 'text-gray-400 group-hover:text-indigo-600 group-hover:border-indigo-600' }}">C</span>
                                            <span class="truncate"> Cost
                                                Center</span>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="{{ route('costCenterHierarchy') }}"
                                            class="group flex gap-x-3 rounded-md p-2 text-sm/6 font-semibold {{ request()->is('tkyc/costcenterhierarchy*') ? 'bg-gray-50 text-indigo-600' : 'text-gray-700 hover:bg-gray-50 hover:text-indigo-600' }}">
                                            <span
                                                class="flex size-6 shrink-0 items-center justify-center rounded-lg border border-gray-200 bg-white text-[0.625rem] font-medium {{ request()->is('tkyc/costcenterhierarchy*') ? 'text-indigo-600 border-indigo-600' : 'text-gray-400 group-hover:text-indigo-600 group-hover:border-indigo-600' }}">H</span>
                                            <span class="truncate">Cost
                                                Center Heirarchy</span>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="-mx-6 mt-auto">
                                <div
                                    class="flex items-center gap-x-4 px-6 py-3 text-sm/6 font-semibold text-gray-900">
                                    <img class="size-8 rounded-full bg-gray-50"
                                        src="data:image/png;base64,{{ $imageData ?? '' }}" alt="Image Description">
                                    <span class="sr-only">Your profile</span>
                                    <span aria-hidden="true">{{ $namaUser ?? 'Admin' }}</span>
                                    <a href="{{ route('back') }}">
                                        <svg class="w-6 h-6 text-gray-700 hover:bg-gray-50 hover:text-indigo-600" aria-hidden="true"
                                            xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            fill="none" viewBox="0 0 24 24">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                                stroke-width="2"
                                                d="M16 12H4m12 0-4 4m4-4-4-4m3-4h2a3 3 0 0 1 3 3v10a3 3 0 0 1-3 3h-2" />
                                        </svg>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>

            <div class="sticky top-0 z-40 flex items-center gap-x-6 bg-white px-4 py-4 shadow-sm sm:px-6 lg:hidden">
                <button type="button" class="-m-2.5 p-2.5 text-gray-700 lg:hidden">
                    <span class="sr-only">Open sidebar</span>
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                        aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                    </svg>
                </button>
                <div class="flex-1 text-sm/6 font-semibold text-gray-900">Dashboard</div>
                <a href="#">
                    <span class="sr-only">Your profile</span>
                    <img class="size-8 rounded-full bg-gray-50"
                        src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80"
                        alt="">
                </a>
            </div>

            <main class="py-10 lg:pl-72 min-h-screen" style="background-color: #F8FAFC;">
                <div class="px-4 sm:px-6 lg:px-8">

                    {{ $content }}
                </div>
            </main>
        </div>

    </div>

    <!-- Popup Modal Structure -->
    <div id="confirmationModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                <div class="p-4 md:p-5 text-center">
                    <div id="lottie-container" class="mx-auto mb-4" style="width: 100%; max-width: 170px; height: auto;"></div>
                    <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to leave this site?</h3>
                    <button id="confirmBtn" type="button" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                        Yes, I'm sure
                    </button>
                    <button id="cancelBtn" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                        No, cancel
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bodymovin/5.7.6/lottie.min.js"></script>
    <script>
        // Initialize Lottie animation
        document.addEventListener('DOMContentLoaded', function() {
            var animation = lottie.loadAnimation({
                container: document.getElementById('lottie-container'), // The container where the animation will be placed
                renderer: 'svg', // Use SVG rendering
                loop: true, // Animation will loop
                autoplay: true, // Play the animation automatically
                path: "{{ asset('/lottie/confirmation.json') }}" // Path to your Lottie JSON file
            });
        });

        // Function to show the custom modal
        function showLeavePageConfirmation(event) {
            event.preventDefault(); // Prevent the default link behavior

            // Display the custom modal
            document.getElementById('confirmationModal').classList.remove('hidden');

            // Get the clicked link to navigate after confirmation
            const linkToNavigate = event.target.closest('a'); // Ensure it's the closest <a> tag

            // Handle the confirmation button
            document.getElementById('confirmBtn').addEventListener('click', function() {
                window.location.href = linkToNavigate.href; // Navigate to the link
            });

            // Handle the cancel button
            document.getElementById('cancelBtn').addEventListener('click', function() {
                document.getElementById('confirmationModal').classList.add('hidden'); // Close the modal
            });
        }

        // Add event listeners to all GET links on the page
        document.addEventListener('DOMContentLoaded', function() {
            const routesToTrack = [
                'tkyc/employee/create',
                'tkyc/employee/\\d+/edit', // Adjusted regex for dynamic ID
                'tkyc/costcenterhierarchy/create',
                'tkyc/costcenterhierarchy/\\d+/edit', // Adjusted regex for dynamic ID
                'tkyc/title/create',
                'tkyc/title/\\d+/edit', // Adjusted regex for dynamic ID
                'tkyc/costcenter/create',
                'tkyc/costcenter/\\d+/edit', // Adjusted regex for dynamic ID
                'tkyc/application/create',
                'tkyc/application/\\d+/edit', // Adjusted regex for dynamic ID
            ];

            // Check if current path matches any of the tracked routes
            const currentPath = window.location.pathname.replace(/^\//, ''); // Remove leading slash
            const shouldTrack = routesToTrack.some(route => new RegExp(`^${route}$`).test(currentPath));

            if (shouldTrack) {
                // Handle link clicks
                document.querySelectorAll('a').forEach(link => {
                    if (link.href && link.href.startsWith(window.location.origin)) {
                        link.addEventListener('click', showLeavePageConfirmation);
                    }
                });
            }
        });
    </script>

    <script>
        /*! DataTables Tailwind CSS integration
         */

        (function(factory) {
            if (typeof define === 'function' && define.amd) {
                // AMD
                define(['jquery', 'datatables.net'], function($) {
                    return factory($, window, document);
                });
            } else if (typeof exports === 'object') {
                // CommonJS
                var jq = require('jquery');
                var cjsRequires = function(root, $) {
                    if (!$.fn.dataTable) {
                        require('datatables.net')(root, $);
                    }
                };

                if (typeof window === 'undefined') {
                    module.exports = function(root, $) {
                        if (!root) {
                            // CommonJS environments without a window global must pass a
                            // root. This will give an error otherwise
                            root = window;
                        }

                        if (!$) {
                            $ = jq(root);
                        }

                        cjsRequires(root, $);
                        return factory($, root, root.document);
                    };
                } else {
                    cjsRequires(window, jq);
                    module.exports = factory(jq, window, window.document);
                }
            } else {
                // Browser
                factory(jQuery, window, document);
            }
        }(function($, window, document) {
            'use strict';
            var DataTable = $.fn.dataTable;



            /*
             * This is a tech preview of Tailwind CSS integration with DataTables.
             */

            // Set the defaults for DataTables initialisation
            $.extend(true, DataTable.defaults, {
                renderer: 'tailwindcss'
            });


            // Default class modification
            $.extend(true, DataTable.ext.classes, {
                container: "dt-container dt-tailwindcss",
                search: {
                    input: "border placeholder-gray-500 ml-2 px-3 py-2 rounded-lg border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 "
                },
                length: {
                    select: "border px-3 py-2 rounded-lg border-gray-200 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 "
                },
                processing: {
                    container: "dt-processing"
                },
                paging: {
                    active: 'font-semibold bg-gray-100 ',
                    notActive: 'bg-white ',
                    button: 'relative inline-flex justify-center items-center space-x-2 border px-4 py-2 -mr-px leading-6 hover:z-10 focus:z-10 active:z-10 border-gray-200 active:border-gray-200 active:shadow-none ',
                    first: 'rounded-l-lg',
                    last: 'rounded-r-lg',
                    enabled: 'text-gray-800 hover:text-gray-900 hover:border-gray-300 hover:shadow-sm focus:ring focus:ring-gray-300 focus:ring-opacity-25',
                    notEnabled: 'text-gray-300 '
                },
                table: 'dataTable min-w-full text-sm align-middle whitespace-nowrap',
                thead: {
                    row: 'border-b border-gray-100 ',
                    cell: 'px-3 py-4 text-gray-900 bg-gray-100/75 font-semibold text-left'
                },
                tbody: {
                    row: 'even:bg-gray-50',
                    cell: 'p-3'
                },
                tfoot: {
                    row: 'even:bg-gray-50',
                    cell: 'p-3 text-left'
                },
            });

            DataTable.ext.renderer.pagingButton.tailwindcss = function(settings, buttonType, content, active,
                disabled) {
                var classes = settings.oClasses.paging;
                var btnClasses = [classes.button];

                btnClasses.push(active ? classes.active : classes.notActive);
                btnClasses.push(disabled ? classes.notEnabled : classes.enabled);

                var a = $('<a>', {
                        'href': disabled ? null : '#',
                        'class': btnClasses.join(' ')
                    })
                    .html(content);

                return {
                    display: a,
                    clicker: a
                };
            };

            DataTable.ext.renderer.pagingContainer.tailwindcss = function(settings, buttonEls) {
                var classes = settings.oClasses.paging;

                buttonEls[0].addClass(classes.first);
                buttonEls[buttonEls.length - 1].addClass(classes.last);

                return $('<ul/>').addClass('pagination').append(buttonEls);
            };

            DataTable.ext.renderer.layout.tailwindcss = function(settings, container, items) {
                var row = $('<div/>', {
                        "class": items.full ?
                            'grid grid-cols-1 gap-4 mb-4' : 'grid grid-cols-2 gap-4 mb-4'
                    })
                    .appendTo(container);

                $.each(items, function(key, val) {
                    var klass;

                    // Apply start / end (left / right when ltr) margins
                    if (val.table) {
                        klass = 'col-span-2';
                    } else if (key === 'start') {
                        klass = 'justify-self-start';
                    } else if (key === 'end') {
                        klass = 'col-start-2 justify-self-end';
                    } else {
                        klass = 'col-span-2 justify-self-center';
                    }

                    $('<div/>', {
                            id: val.id || null,
                            "class": klass + ' ' + (val.className || '')
                        })
                        .append(val.contents)
                        .appendTo(row);
                });
            };


            return DataTable;
        }));
    </script>
</body>


</html>
