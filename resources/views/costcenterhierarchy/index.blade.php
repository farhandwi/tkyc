<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cost Center Hierarchy List</title>
    @vite('resources/css/app.css')
    <link rel="icon" href="/images/favicon-tugu.png" type="image/x-icon">
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
                    <x-slot:pageTitle>Cost Center Hierarchy List</x-slot:pageTitle>
                </x-page-template>
                <a href="{{route('costCenterHierarchyCreate')}}" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-6 py-2.5 text-center me-2 mb-2 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                </a>
            </div>

            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th> Id</th>
                        <th>Name</th>
                        <th>Effective Start Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($costCenters as $costCenter)
                    <tr>
                        <td>{{ $costCenter->cost_center}}</td>
                        <td>{{ $costCenter->cost_center_name }}</td>
                        <td>{{ \Carbon\Carbon::parse($costCenter->start_effective_date)->format('d-M-Y') }}</td>
                        <td>
                            <div class="flex space-x-2">
                                <!-- Blue Button to Open Modal -->
                                <a href="#"
                                    class="inline-flex items-center justify-center text-blue-600 border border-blue-600 rounded-lg w-10 h-10 hover:bg-blue-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-300 dark:border-blue-300 dark:text-blue-300 dark:hover:bg-blue-300 dark:hover:text-white dark:focus:ring-blue-800"
                                    data-id="{{  $costCenter->cost_center }}"
                                    data-name="{{ $costCenter->cost_center_name }}"
                                    data-dr="{{ optional($costCenter->directReport)->cost_center ? $costCenter->directReport->cost_center . ' | ' . $costCenter->directReport->cost_center_name : 'N/A' }}"
                                    data-cp="{{ optional($costCenter->poss)->cost_center ? $costCenter->poss->cost_center . ' | ' . $costCenter->poss->cost_center_name : 'N/A' }}"
                                    data-dh="{{ optional($costCenter->dh)->cost_center ? $costCenter->dh->cost_center . ' | ' . $costCenter->dh->cost_center_name : 'N/A' }}"
                                    data-gh="{{ optional($costCenter->gh)->cost_center ? $costCenter->gh->cost_center . ' | ' . $costCenter->gh->cost_center_name : 'N/A' }}"
                                    data-svp="{{ optional($costCenter->svp)->cost_center ? $costCenter->svp->cost_center . ' | ' . $costCenter->svp->cost_center_name : 'N/A' }}"
                                    data-dir="{{ optional($costCenter->dir)->cost_center ? $costCenter->dir->cost_center . ' | ' . $costCenter->dir->cost_center_name : 'N/A' }}"
                                    data-sd="{{ \Carbon\Carbon::parse($costCenter->start_effective_date)->format('d-M-Y') }}"
                                    data-ed="{{ $costCenter->end_effective_date? \Carbon\Carbon::parse($costCenter->end_effective_date)->format('d-M-Y')  : 'N/A' }}"
                                    data-hnm="{{ $costCenter->mapEmployeeTitle->first()?->mTitle?->mapEmployeeTitle?->first()?->mEmployeeGeneralInfo?->name ?? 'N/A' }}"
                                    data-hs="  {{ optional(optional($costCenter->mapEmployeeTitle->first())->mTitle)->start_effective_date ? \Carbon\Carbon::parse(optional($costCenter->mapEmployeeTitle->first()?->mTitle)->start_effective_date)->format('d-M-Y') : 'N/A' }}"
                                    data-he="  {{ optional(optional($costCenter->mapEmployeeTitle->first())->mTitle)->end_effective_date ? \Carbon\Carbon::parse(optional($costCenter->mapEmployeeTitle->first()?->mTitle)->end_effective_date)->format('d-M-Y') : 'N/A' }}"
                                    onclick="openModalEmp(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                </a>
                                <a href="{{ route('costCenterHierarchyEdit', ['id' => $costCenter->cost_center]) }}"
                                    class="inline-flex items-center justify-center text-yellow-600 border border-yellow-600 rounded-lg w-10 h-10 hover:bg-yellow-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:border-yellow-300 dark:text-yellow-300 dark:hover:bg-yellow-300 dark:hover:text-white dark:focus:ring-yellow-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>

                                </a>
                                <button data-modal-target="popupDeleteCostCenter-modal" data-modal-toggle="popupDeleteCostCenter-modal" class="inline-flex items-center justify-center text-red-600 border border-red-600 rounded-lg w-10 h-10 hover:bg-red-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-300 dark:border-red-300 dark:text-red-300 dark:hover:bg-red-300 dark:hover:text-white dark:focus:ring-red-800"
                                    data-id="{{  $costCenter->cost_center }}"
                                    data-name="{{ $costCenter->cost_center_name }}">
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



            <div id="costCenterModal" class="hidden fixed inset-0 z-50 flex justify-end items-center">
                <div class="relative bg-white rounded-lg p-6 w-[75vw] h-full max-h-screen">
                    <button onclick="closeModalEmp()" type="button" class="absolute top-3 right-3 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 inline-flex justify-center items-center">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                    </button>
                    <div class="space-y-4 overflow-y-auto h-full">

                        <h2 class="text-4xl font-extrabold dark:text-white modalName"></h2>

                        <p class="my-4 text-lg text-gray-500 ">No:<span class="modalCostCenterId"></span></p>
                        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Direct Report</dt>
                        <dd class="text-base font-semibold"><span class="modalDirectReport"></span></dd>
                        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">

                        <div class="grid grid-cols-1  ">

                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Direktur Cost Center</dt>
                                <dd class="text-base font-semibold"><span id="modalDir"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">SVP Cost Center</dt>
                                <dd class="text-base font-semibold"><span id="modalSvp"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">GH Cost Center</dt>
                                <dd class="text-base font-semibold"><span id="modalGh"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">DH Cost Center</dt>
                                <dd class="text-base font-semibold"><span id="modalDh"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">POSS Cost Center</dt>
                                <dd class="text-base font-semibold"><span id="modalCenterPoss"></span></dd>
                            </div>


                        </div>
                        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
                        <div class="grid grid-cols-2 ">

                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Effective Start Date</dt>
                                <dd class="text-base font-semibold"><span id="modalStartDate"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Effective End Date</dt>
                                <dd class="text-base font-semibold"><span id="modalEndDate"></span></dd>
                            </div>
                        </div>
                        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
                        <div class="grid grid-cols-1 ">

                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Name</dt>
                                <dd class="text-base font-semibold"><span id="headName"></span></dd>
                            </div>

                        </div>
                        <div class="grid grid-cols-2">
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Effective Start Date</dt>
                                <dd class="text-base font-semibold"><span id="headStart"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Effective End Date</dt>
                                <dd class="text-base font-semibold"><span id="headEnd"></span></dd>
                            </div>
                        </div>
                    </div>



                </div>


            </div>

            </div>
            <!-- Delete Modal -->





            <!-- Modal Background -->
            <div id="popupDeleteCostCenter-modal" tabindex="-1" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-gray-800 bg-opacity-75">
                <form autocomplete="off" id="deleteCostCenterForm" method="POST" action="{{route('costCenterHierarchyDestroy')}}">
                    @csrf
                    @method('DELETE')
                    <input type="hidden" name="costCenterId" id="modalCostCenterIdInput">
                    <div class="relative p-4 w-full max-w-md max-h-full">
                        <!-- Modal Content -->
                        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
                            <!-- Close Button -->
                            <button type="button" class="absolute top-3 end-2.5 text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white" data-modal-hide="popupDeleteCostCenter-modal">
                                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                </svg>
                                <span class="sr-only">Close modal</span>
                            </button>

                            <!-- Modal Body -->
                            <div class="p-4 md:p-5 text-center">
                                <svg class="mx-auto mb-4 text-gray-400 w-12 h-12 dark:text-gray-200" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 11V6m0 8h.01M19 10a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                                </svg>
                                <h3 class="mb-5 text-lg font-normal text-gray-500 dark:text-gray-400">Are you sure you want to delete this Cost Center?</h3>
                                <p class="mb-2 text-m font-normal text-gray-500 dark:text-gray-400">
                                    Name: <span id="modalNameDelete" class="text-black underline"></span>
                                </p>
                                <p class="mb-2 text-m font-normal text-gray-500 dark:text-gray-400">
                                    Cost Center Id: <span id="modalCostCenterIdDelete" class="text-black underline"></span>
                                </p>

                                <!-- Action Buttons -->
                                <button type="submit" class="text-white bg-red-600 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 dark:focus:ring-red-800 font-medium rounded-lg text-sm inline-flex items-center px-5 py-2.5 text-center">
                                    Yes, I'm sure
                                </button>
                                <button data-modal-hide="popupDeleteCostCenter-modal" type="button" class="py-2.5 px-5 ms-3 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                                    No, cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>


        </x-slot:content>
    </x-layout>




    <script>
        $(document).ready(function() {
            $('#myTable').DataTable(); // Initialize DataTable
        });

        // Function to open the modal and populate it with employee details
        function openModalEmp(button) {

            var id = $(button).data('id');
            var name = $(button).data('name');
            var directReport = $(button).data('dr');
            var centerPoss = $(button).data('cp');
            var dh = $(button).data('dh');
            var gh = $(button).data('gh');
            var svp = $(button).data('svp');
            var dir = $(button).data('dir');
            var startDate = $(button).data('sd');
            var endDate = $(button).data('ed');

            var headName = $(button).data('hnm');
            var headStart = $(button).data('hs');
            var headEnd = $(button).data('he');


            // Populate modal with the data


            $('.modalCostCenterId').text(id);
            $('.modalName').text(name);
            $('.modalDirectReport').text(directReport);
            $('#modalCenterPoss').text(centerPoss);
            $('#modalDh').text(dh);
            $('#modalGh').text(gh);
            $('#modalSvp').text(svp);
            $('#modalDir').text(dir);
            $('#modalStartDate').text(startDate);
            $('#modalEndDate').text(endDate);
            $('#headName').text(headName);
            $('#headStart').text(headStart);
            $('#headEnd').text(headEnd);


            // Show the modal with sliding effect
            $('#costCenterModal').css("display", "flex"); // Set display to flex before adding class
            setTimeout(function() {
                $('#costCenterModal').addClass('show'); // Add 'show' class to trigger slide-in effect
                $('#costCenterModal').css("opacity", "1"); // Ensure opacity is set to visible
                $('#costCenterModal').css("transform", "translateX(0)"); // Ensure position is reset for next open
            }, 10); // Small timeout to ensure it takes effect after being shown
        }

        // Function to close the modal
        function closeModalEmp() {
            $('#costCenterModal').removeClass('show'); // Remove 'show' class

            // Wait for the transition to finish before hiding it completely
            setTimeout(function() {
                $('#costCenterModal').css("display", "none"); // Hide it completely after animation
                $('#costCenterModal').css("opacity", "0"); // Reset opacity for next open
                $('#costCenterModal').css("transform", "translateX(100%)"); // Reset position for next open
            }, 10); // Match this duration with your CSS transition duration
        }
    </script>

    <style>
        /* Add this to your CSS file */
        #costCenterModal {
            transform: translateX(100%);
            /* Start off-screen to the right */
            transition: transform 0.5s ease, opacity 0.5s ease;
            /* Smooth transition for sliding and fading */
            opacity: 0;
            /* Start invisible */
            display: none;
            /* Initially hidden */
        }

        #costCenterModal.show {
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
            const deleteButtons = document.querySelectorAll('[data-modal-target="popupDeleteCostCenter-modal"]');

            deleteButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Get the name and ID from data attributes
                    const employeeName = this.getAttribute('data-name');
                    const employeeId = this.getAttribute('data-id');

                    // Populate the modal spans
                    $('#modalNameDelete').text(employeeName);
                    $('#modalCostCenterIdDelete').text(employeeId);
                    // document.getElementById('modalName').textContent = employeeName;
                    // document.getElementById('modalEmployeeId').textContent = employeeId;

                    // Set the hidden input value for form submission
                    document.getElementById('modalCostCenterIdInput').value = employeeId;
                });
            });
        });
    </script>

</body>

</html>
