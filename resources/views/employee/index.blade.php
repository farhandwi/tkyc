<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee List</title>
    <link rel="icon" href="/images/favicon-tugu.png" type="image/x-icon">
    @vite('resources/css/app.css')

</head>



</head>

<body>

    <x-layout :imageData="$imageData ?? ''" :namaUser="$namaUser">
        <x-slot:content>
            @if (session('success'))
            <div class="p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 dark:bg-gray-800 dark:text-green-400" role="alert">
                <span class="font-medium">Success alert!</span> {{ session('success') }}
            </div>
            @endif

            @if (session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">Error alert!</span>{{ session('error') }}
            </div>
            @endif
            <div class="flex justify-between items-center mb-4">
                <x-page-template>
                    <x-slot:pageTitle>Employee List</x-slot:pageTitle>
                </x-page-template>
                <a href="{{ route('employeeCreate') }}" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-6 py-2.5 text-center me-2 mb-2 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                </a>
            </div>


            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>Employee Id</th>
                        <th>Name</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($employees as $employee)
                    <tr>
                        <td>{{ $employee->BP }}</td>
                        <td>{{ $employee->name }}</td>
                        <td>
                            <div class="flex space-x-2">
                                <!-- Blue Button to Open Modal -->
                                <a href="{{ route('employeeShow', ['id' => $employee->BP]) }}"
                                    class="inline-flex items-center justify-center text-blue-600 border border-blue-600 rounded-lg w-10 h-10 hover:bg-blue-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-300 dark:border-blue-300 dark:text-blue-300 dark:hover:bg-blue-300 dark:hover:text-white dark:focus:ring-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                </a>
                                <a href="{{ route('employeeEdit', ['id' => $employee->BP]) }}"
                                    class="inline-flex items-center justify-center text-yellow-600 border border-yellow-600 rounded-lg w-10 h-10 hover:bg-yellow-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:border-yellow-300 dark:text-yellow-300 dark:hover:bg-yellow-300 dark:hover:text-white dark:focus:ring-yellow-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>

                                </a>
                                <button data-modal-target="popupDeleteEmployee-modal" data-modal-toggle="popupDeleteEmployee-modal" class="inline-flex items-center justify-center text-red-600 border border-red-600 rounded-lg w-10 h-10 hover:bg-red-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-300 dark:border-red-300 dark:text-red-300 dark:hover:bg-red-300 dark:hover:text-white dark:focus:ring-red-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <!-- Modal for detail -->



            <div id="employeeModal" class="hidden fixed inset-0 z-50 flex justify-end items-center">
                <div class="relative bg-white rounded-lg p-6 w-[75vw] h-full max-h-screen">
                    <button onclick="closeModalEmp()" type="button" class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                    <div class="space-y-4 overflow-y-auto h-full">

                        <h2 class="text-4xl font-extrabold dark:text-white modalName"></h2>
                        <p class="my-4 text-lg text-gray-500 modalEmployeeId"></p>

                        <div class="sm:hidden">
                            <label for="tabs" class="sr-only">Select tab</label>
                            <select id="tabs" class="bg-gray-50 border-0 border-b border-gray-200 text-gray-900 text-sm rounded-t-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                <!-- known as ge -->
                                <option>General Information</option>
                                <!-- known as ei -->
                                <option>Employment Information</option>
                                <!-- known as epb -->
                                <option>Educational and Professional Background</option>
                            </select>
                        </div>
                        <ul class="hidden text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg sm:flex dark:divide-gray-600 dark:text-gray-400 rtl:divide-x-reverse" id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
                            <li class="w-full">
                                <button id="ge-tab" data-tabs-target="#ge" type="button" role="tab" aria-controls="ge" aria-selected="true" class="inline-block w-full p-4 rounded-ss-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">General Information</button>
                            </li>
                            <li class="w-full">
                                <button id="ei-tab" data-tabs-target="#ei" type="button" role="tab" aria-controls="ei" aria-selected="false" class="inline-block w-full p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Employment Information</button>
                            </li>
                            <li class="w-full">
                                <button id="epb-tab" data-tabs-target="#epb" type="button" role="tab" aria-controls="epb" aria-selected="false" class="inline-block w-full p-4 rounded-se-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">Educational and Professional Background</button>
                            </li>
                        </ul>
                        <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">
                            <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="ge" role="tabpanel" aria-labelledby="ge-tab">


                                <div class="grid grid-cols-2 gap-4">
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Full Name</dt>
                                        <dd class="text-base font-semibold"><span class="modalName"></span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Email address</dt>
                                        <dd class="text-base font-semibold"><span id="modalEmail"></span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Home address</dt>
                                        <dd class="text-base font-semibold"><span id="modalAddress"></span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Phone number</dt>
                                        <dd class="text-base font-semibold"><span id="modalPhone"></span></dd>
                                    </div>
                                </div>

                            </div>
                            <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="ei" role="tabpanel" aria-labelledby="ei-tab">


                                <div class="grid grid-cols-2 gap-4">
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Employee id</dt>
                                        <dd class="text-base font-semibold"><span class="modalEmployeeId"></span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Position</dt>
                                        <dd class="text-base font-semibold"><span id="modalPosition"></span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Salary</dt>
                                        <dd class="text-base font-semibold"><span id="modalSalary"></span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Department</dt>
                                        <dd class="text-base font-semibold"><span id="modalDepartment"></span></dd>
                                    </div>

                                </div>
                            </div>
                            <div class="hidden p-4 bg-white rounded-lg dark:bg-gray-800" id="epb" role="tabpanel" aria-labelledby="epb-tab">
                                <div id="accordion-flush" data-accordion="collapse" data-active-classes="bg-white dark:bg-gray-800 text-gray-900 dark:text-white" data-inactive-classes="text-gray-500 dark:text-gray-400">
                                    <h2 id="accordion-flush-heading-1">
                                        <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-left rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400" data-accordion-target="#accordion-flush-body-1" aria-expanded="true" aria-controls="accordion-flush-body-1">
                                            <span>What is Flowbite?</span>
                                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="accordion-flush-body-1" class="hidden" aria-labelledby="accordion-flush-heading-1">
                                        <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                                            <p class="mb-2 text-gray-500 dark:text-gray-400">Flowbite is an open-source library of interactive components built on top of Tailwind CSS including buttons, dropdowns, modals, navbars, and more.</p>
                                            <p class="text-gray-500 dark:text-gray-400">Check out this guide to learn how to <a href="/docs/getting-started/introduction/" class="text-blue-600 dark:text-blue-500 hover:underline">get started</a> and start developing websites even faster with components on top of Tailwind CSS.</p>
                                        </div>
                                    </div>
                                    <h2 id="accordion-flush-heading-2">
                                        <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-left rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400" data-accordion-target="#accordion-flush-body-2" aria-expanded="false" aria-controls="accordion-flush-body-2">
                                            <span>Is there a Figma file available?</span>
                                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="accordion-flush-body-2" class="hidden" aria-labelledby="accordion-flush-heading-2">
                                        <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                                            <p class="mb-2 text-gray-500 dark:text-gray-400">Flowbite is first conceptualized and designed using the Figma software so everything you see in the library has a design equivalent in our Figma file.</p>
                                            <p class="text-gray-500 dark:text-gray-400">Check out the <a href="https://flowbite.com/figma/" class="text-blue-600 dark:text-blue-500 hover:underline">Figma design system</a> based on the utility classes from Tailwind CSS and components from Flowbite.</p>
                                        </div>
                                    </div>
                                    <h2 id="accordion-flush-heading-3">
                                        <button type="button" class="flex items-center justify-between w-full py-5 font-medium text-left rtl:text-right text-gray-500 border-b border-gray-200 dark:border-gray-700 dark:text-gray-400" data-accordion-target="#accordion-flush-body-3" aria-expanded="false" aria-controls="accordion-flush-body-3">
                                            <span>What are the differences between Flowbite and Tailwind UI?</span>
                                            <svg data-accordion-icon class="w-3 h-3 rotate-180 shrink-0" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5 5 1 1 5" />
                                            </svg>
                                        </button>
                                    </h2>
                                    <div id="accordion-flush-body-3" class="hidden" aria-labelledby="accordion-flush-heading-3">
                                        <div class="py-5 border-b border-gray-200 dark:border-gray-700">
                                            <p class="mb-2 text-gray-500 dark:text-gray-400">The main difference is that the core components from Flowbite are open source under the MIT license, whereas Tailwind UI is a paid product. Another difference is that Flowbite relies on smaller and standalone components, whereas Tailwind UI offers sections of pages.</p>
                                            <p class="mb-2 text-gray-500 dark:text-gray-400">However, we actually recommend using both Flowbite, Flowbite Pro, and even Tailwind UI as there is no technical reason stopping you from using the best of two worlds.</p>
                                            <p class="mb-2 text-gray-500 dark:text-gray-400">Learn more about these technologies:</p>
                                            <ul class="ps-5 text-gray-500 list-disc dark:text-gray-400">
                                                <li><a href="https://flowbite.com/pro/" class="text-blue-600 dark:text-blue-500 hover:underline">Flowbite Pro</a></li>
                                                <li><a href="https://tailwindui.com/" rel="nofollow" class="text-blue-600 dark:text-blue-500 hover:underline">Tailwind UI</a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- END -->

                </div>


            </div>
            <!-- Delete Modal -->

            <form autocomplete="off" id="deleteEmployeeForm" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" name="employee_id" id="modalEmployeeIdInput">

                <div id="popupDeleteEmployee-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popupDeleteEmployee-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>
                            <div class="p-4 md:p-5 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this Employee?</h3>
                                <p class="mb-2 text-m font-normal text-gray-500 dark:text-gray-400">
                                    Name: <span id="modalNameDelete" style="color: black; text-decoration: underline;"></span>
                                </p>
                                <p class="mb-2 text-m font-normal text-gray-500 dark:text-gray-400">
                                    Employee Id: <span id="modalEmployeeIdDelete" style="color: black; text-decoration: underline;"></span>
                                </p>


                                <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                    Yes, I'm sure
                                </button>
                                <button data-modal-hide="popupDeleteEmployee-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    No, cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </x-slot:content>
    </x-layout>




    <script>
        $(document).ready(function() {
            $('#myTable').DataTable(); // Initialize DataTable
        });

        // Function to open the modal and populate it with employee details
        function openModalEmp(button) {
            var name = $(button).data('name');
            var position = $(button).data('position');
            var email = $(button).data('email');
            var phone = $(button).data('phone');
            var address = $(button).data('address');
            var salary = $(button).data('salary');
            var department = $(button).data('department');
            var employeeId = $(button).data('id'); //id employee

            // Populate modal with the data
            $('.modalName').text(name); // type class for reuse on the same modal
            $('#modalPosition').text(position);
            $('#modalEmail').text(email);
            $('#modalPhone').text(phone);
            $('#modalAddress').text(address);
            $('#modalSalary').text('$' + salary);
            $('#modalDepartment').text(department);
            $('.modalEmployeeId').text(employeeId); // type class for reuse on the same modal

            // Show the modal with sliding effect
            $('#employeeModal').css("display", "flex"); // Set display to flex before adding class
            setTimeout(function() {
                $('#employeeModal').addClass('show'); // Add 'show' class to trigger slide-in effect
                $('#employeeModal').css("opacity", "1"); // Ensure opacity is set to visible
                $('#employeeModal').css("transform", "translateX(0)"); // Ensure position is reset for next open
            }, 10); // Small timeout to ensure it takes effect after being shown
        }

        // Function to close the modal
        function closeModalEmp() {
            $('#employeeModal').removeClass('show'); // Remove 'show' class

            // Wait for the transition to finish before hiding it completely
            setTimeout(function() {
                $('#employeeModal').css("display", "none"); // Hide it completely after animation
                $('#employeeModal').css("opacity", "0"); // Reset opacity for next open
                $('#employeeModal').css("transform", "translateX(100%)"); // Reset position for next open
            }, 10); // Match this duration with your CSS transition duration
        }
    </script>

    <style>
        /* Add this to your CSS file */
        #employeeModal {
            transform: translateX(100%);
            /* Start off-screen to the right */
            transition: transform 0.5s ease, opacity 0.5s ease;
            /* Smooth transition for sliding and fading */
            opacity: 0;
            /* Start invisible */
            display: none;
            /* Initially hidden */
        }

        #employeeModal.show {
            transform: translateX(0);
            /* Slide into view */
            opacity: 1;
            /* Make it visible */
            display: flex;
            /* Ensure it uses flex layout when shown */
        }
    </style>




    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Get all delete buttons
            const deleteButtons = document.querySelectorAll('[data-modal-target="popupDeleteEmployee-modal"]');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Get the name and ID from data attributes
                    const employeeName = this.getAttribute('data-name');
                    const employeeId = this.getAttribute('data-id');

                    // Populate the modal spans
                    $('#modalNameDelete').text(employeeName);
                    $('#modalEmployeeIdDelete').text(employeeId);
                    // document.getElementById('modalName').textContent = employeeName;
                    // document.getElementById('modalEmployeeId').textContent = employeeId;

                    // Set the hidden input value for form submission
                    document.getElementById('modalEmployeeIdInput').value = employeeId;
                });
            });
        });
    </script>

</body>

</html>