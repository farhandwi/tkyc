<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cost Center List</title>
    @vite('resources/css/app.css')
    <link rel="icon" href="/images/favicon-tugu.png" type="image/x-icon">
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
                    <x-slot:pageTitle>Cost Center List</x-slot:pageTitle>
                </x-page-template>
                <a href="{{route('costCenterCreate')}}" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-6 py-2.5 text-center me-2 mb-2 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                </a>
            </div>

            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th> Id</th>
                        <th>Cost Center</th>
                        <th>Name</th>
                        <th>TMT</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($costCenters as $costCenter)
                    <tr>
                        <td>{{ $costCenter->id}}</td>
                        <td>{{ $costCenter->cost_ctr }}</td>
                        <td>{{$costCenter->ct_description}}</td>
                        <td>{{ \Carbon\Carbon::parse($costCenter->TMT)->format('d-M-Y') }}</td>
                        <td>
                            <div class="flex space-x-2">
                                <!-- Blue Button to Open Modal -->
                                <a href="#"
                                    class="inline-flex items-center justify-center text-blue-600 border border-blue-600 rounded-lg w-10 h-10 hover:bg-blue-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-300 dark:border-blue-300 dark:text-blue-300 dark:hover:bg-blue-300 dark:hover:text-white dark:focus:ring-blue-800"
                                    data-id="{{ $costCenter->id}}"
                                    data-name="{{ $costCenter->ct_description ?? 'N/A'}}"
                                    data-old="{{ $costCenter->oldCostCenter?->ct_description ?? 'N/A' }}"
                                    data-merge="{{ $costCenter->mergedCostCenter?->ct_description ?? 'N/A' }}"
                                    data-prod="{{ $costCenter->prod_ctr ?? 'N/A' }}"
                                    data-cost="{{ $costCenter->cost_ctr ?? 'N/A' }}"
                                    data-prof="{{ $costCenter->profit_ctr ?? 'N/A' }}"
                                    data-plant="{{ $costCenter->plant ?? 'N/A' }}"
                                    data-ct="{{ $costCenter->ct_description ?? 'N/A' }}"
                                    data-remark="{{ $costCenter->remark ?? 'N/A' }}"
                                    data-skd="{{ $costCenter->SKD ?? 'N/A' }}"
                                    data-tmt="{{ $costCenter->TMT ? \Carbon\Carbon::parse($costCenter->TMT)->format('d-M-Y') : 'N/A' }}"
                                    data-crtby="{{ $costCenter->create_by ?? 'N/A' }}"
                                    data-crtdt="{{ $costCenter->create_date ? \Carbon\Carbon::parse($costCenter->create_date)->format('d-M-Y') : 'N/A' }}"
                                    data-expdt="{{ $costCenter->exp_date ? \Carbon\Carbon::parse($costCenter->exp_date)->format('d-M-Y') : 'N/A' }}"

                                    onclick="openModalEmp(this)">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                </a>
                                <a href="{{ route('costCenterEdit', ['id' => $costCenter->id]) }}"
                                    class="inline-flex items-center justify-center text-yellow-600 border border-yellow-600 rounded-lg w-10 h-10 hover:bg-yellow-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:border-yellow-300 dark:text-yellow-300 dark:hover:bg-yellow-300 dark:hover:text-white dark:focus:ring-yellow-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>

                                </a>

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
                        <p class="my-4 text-lg text-gray-500 modalCostCenterId "></p>
                        <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">

                        <div class="grid grid-cols-2 gap-4">

                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400"> Old </dt>
                                <dd class="text-base font-semibold "><span id="modalOld"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Merge </dt>
                                <dd class="text-base font-semibold"><span id="modalMerge"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Cost Center Name</dt>
                                <dd class="text-base font-semibold"><span class="modalName"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Prod Center</dt>
                                <dd class="text-base font-semibold"><span id="modalProd"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Cost Center</dt>
                                <dd class="text-base font-semibold"><span class="modalCost"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Profit Center</dt>
                                <dd class="text-base font-semibold"><span id="modalProf"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Plant</dt>
                                <dd class="text-base font-semibold"><span id="modalPlant"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">CT Description</dt>
                                <dd class="text-base font-semibold"><span id="modalCt"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Remark</dt>
                                <dd class="text-base font-semibold"><span id="modalRemark"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">SKD</dt>
                                <dd class="text-base font-semibold"><span id="modalSkd"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">TMT</dt>
                                <dd class="text-base font-semibold"><span id="modalTmt"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Create By</dt>
                                <dd class="text-base font-semibold"><span id="modalCrtby"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Create Date</dt>
                                <dd class="text-base font-semibold"><span id="modalCrtdt"></span></dd>
                            </div>
                            <div class="flex flex-col">
                                <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Expired Date</dt>
                                <dd class="text-base font-semibold"><span id="modalExpdt"></span></dd>
                            </div>
                        </div>



                    </div>


                </div>

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
            var old = $(button).data('old');
            var name = $(button).data('name');
            var merge = $(button).data('merge');
            var prod = $(button).data('prod');
            var cost = $(button).data('cost');
            var prof = $(button).data('prof');
            var plant = $(button).data('plant');
            var ct = $(button).data('ct');
            var remark = $(button).data('remark');
            var skd = $(button).data('skd');
            var tmt = $(button).data('tmt');
            var crtby = $(button).data('crtby');
            var crtdt = $(button).data('crtdt');
            var expdt = $(button).data('expdt');



            // Populate modal with the data


            $('.modalCostCenterId').text(id);
            $('#modalOld').text(old);
            $('#modalMerge').text(merge);
            $('.modalName').text(name);
            $('#modalProd').text(prod);
            $('.modalCost').text(cost);
            $('#modalProf').text(prof);
            $('#modalPlant').text(plant);
            $('#modalCt').text(ct);
            $('#modalRemark').text(remark);
            $('#modalSkd').text(skd);
            $('#modalTmt').text(tmt);
            $('#modalCrtby').text(crtby);
            $('#modalCrtdt').text(crtdt);
            $('#modalExpdt').text(expdt);


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






</body>

</html>