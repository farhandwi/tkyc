<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Title List</title>
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
                    <x-slot:pageTitle>Title List</x-slot:pageTitle>
                </x-page-template>
                <a href="{{route('titleCreate')}}" class="text-white bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 shadow-lg shadow-blue-500/50 dark:shadow-lg dark:shadow-blue-800/80 font-medium rounded-lg text-sm px-6 py-2.5 text-center me-2 mb-2 hover:text-white">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M18 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                </a>
            </div>

            <table id="myTable" class="display">
                <thead>
                    <tr>
                        <th>Title Id</th>
                        <th>Name</th>
                        <th>Start Date</th>
                        <th>End Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($titles as $title)
                    <tr>
                        <td>{{ $title->title_id }}</td>
                        <td>{{ $title->title_name }}</td>
                        <td> {{ \Carbon\Carbon::parse($title->start_effective_date)->format('d-M-Y') }}</td>
                        <td> {{ $title->end_effective_date 
        ? \Carbon\Carbon::parse($title->end_effective_date)->format('d-M-Y') 
        : 'N/A' }}</td>

                        <td>
                            <div class="flex space-x-2">
                                <!-- Blue Button to Open Modal -->
                                <a href="{{route('titleShow',['id' => $title->title_id])}}"
                                    class="inline-flex items-center justify-center text-blue-600 border border-blue-600 rounded-lg w-10 h-10 hover:bg-blue-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-blue-300 dark:border-blue-300 dark:text-blue-300 dark:hover:bg-blue-300 dark:hover:text-white dark:focus:ring-blue-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                    </svg>
                                </a>
                                <a href="{{ route('titleEdit', ['id' => $title->title_id]) }}"
                                    class="inline-flex items-center justify-center text-yellow-600 border border-yellow-600 rounded-lg w-10 h-10 hover:bg-yellow-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-yellow-300 dark:border-yellow-300 dark:text-yellow-300 dark:hover:bg-yellow-300 dark:hover:text-white dark:focus:ring-yellow-800">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                                    </svg>

                                </a>
                                <button data-modal-target="popupDeleteEmployee-modal" data-modal-toggle="popupDeleteEmployee-modal" class="inline-flex items-center justify-center text-red-600 border border-red-600 rounded-lg w-10 h-10 hover:bg-red-600 hover:text-white focus:outline-none focus:ring-2 focus:ring-red-300 dark:border-red-300 dark:text-red-300 dark:hover:bg-red-300 dark:hover:text-white dark:focus:ring-red-800"
                                    data-id="{{ $title->title_id }}"
                                    data-name="{{ $title->title_name }}">
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
    </script>
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
