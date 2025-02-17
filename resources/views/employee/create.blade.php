<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Employee</title>
    <link rel="icon" href="/images/favicon-tugu.png" type="image/x-icon">
</head>

<body>
    <x-layout :imageData="$imageData ?? ''" :namaUser="$namaUser">
        <x-slot:content>
            <x-page-template>
                <x-slot:pageTitle>Create Employee</x-slot:pageTitle>
            </x-page-template>
            <div class="space-y-12">


                <!-- Tab Buttons -->
                <ul class="text-sm font-medium text-center text-gray-500 divide-x divide-gray-200 rounded-lg sm:flex dark:divide-gray-600 dark:text-gray-400 rtl:divide-x-reverse" id="fullWidthTab" data-tabs-toggle="#fullWidthTabContent" role="tablist">
                    <li class="w-full">
                        <button id="ge-tab" data-tabs-target="#ge" type="button" role="tab" aria-controls="ge" aria-selected="true" class="inline-block w-full p-4 rounded-ss-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">
                            General Information
                        </button>
                    </li>
                    <li class="w-full">
                        <button id="ei-tab" data-tabs-target="#ei" type="button" role="tab" aria-controls="ei" aria-selected="false" class="inline-block w-full p-4 bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">
                            Additional Information
                        </button>
                    </li>
                    <li class="w-full">
                        <button id="epb-tab" data-tabs-target="#epb" type="button" role="tab" aria-controls="epb" aria-selected="false" class="inline-block w-full p-4 rounded-se-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">
                            Employment Title
                        </button>
                    </li>
                </ul>

                <form autocomplete="off" method="post" action="{{route('employeeStore')}}">
                    @csrf
                    <!-- Tab Content -->
                    <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">

                        <!-- General Information Tab -->
                        <div class="hidden p-4 bg-white rounded-lg md:p-4 dark:bg-gray-800" id="ge" role="tabpanel" aria-labelledby="ge-tab">

                            <h2 class="text-base/7 font-semibold text-gray-900">General Information</h2>


                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                <div class="sm:col-span-full">
                                    <label for="bp" class="block text-sm/6 font-medium text-gray-900">BP (Auto-Generated)</label>
                                    <div class="mt-2">
                                        <input value="{{$newBP}}" type="text" name="bp" id="bp" disabled minlength="10" maxlength="10" title="Must be exactly 10 characters" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full   dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="fullName" class="block text-sm/6 font-medium text-gray-900">Full Name<span class="text-red-500">*</span></label>
                                    <div class="mt-2">
                                        <input type="text" id="fullName" name="fullName" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full   dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="bp" class="block text-sm/6 font-medium text-gray-900">Email<span class="text-red-500">*</span></label>
                                    <div class="mt-2">
                                        <input type="email" id="email" name="email" class=" bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full   dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="ktp" class="block text-sm/6 font-medium text-gray-900">
                                        KTP<span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-2">
                                        <input
                                            type="text"
                                            id="ktp"
                                            name="ktp"
                                            minlength="15"
                                            maxlength="16"
                                            inputmode="numeric"

                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="npwp" class="block text-sm/6 font-medium text-gray-900">
                                        NPWP<span class="text-red-500">*</span>
                                    </label>
                                    <div class="mt-2">
                                        <input
                                            type="text"
                                            id="npwp"
                                            name="npwp"
                                            minlength="15"
                                            maxlength="16"

                                            inputmode="numeric"

                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="phoneNumber" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Phone Number</label>
                                    <div class="mt-2">
                                        <input type="text" inputmode="numeric" name="phoneNumber" id="phoneNumber"
                                            placeholder="+62812345678"
                                            value="+62"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                </div>

                                <div class="sm:col-span-full">

                                    <label for="address" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Address<span class="text-red-500">*</span></label>
                                    <textarea

                                        name="address"
                                        id="address"
                                        rows="4"
                                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                        placeholder="Write the address here..."></textarea>

                                </div>


                            </div>

                        </div>

                        <!-- Additional Information Tab -->
                        <div class="hidden p-4 bg-white rounded-lg md:p-4 dark:bg-gray-800" id="ei" role="tabpanel" aria-labelledby="ei-tab">
                            <h2 class="text-base/7 font-semibold text-gray-900">Employee Additional</h2>


                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">



                                <div class="sm:col-span-3">
                                    <label for="nip1" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP</label>
                                    <div class="mt-2">
                                        <input type="text" name="nip1" id="nip1" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="partnerExternal" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Partner External<span class="text-red-500">*</span></label>
                                    <div class="mt-2">
                                        <input type="text" name="partnerExternal" id="partnerExternal" minlength="10" maxlength="11" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="nip2" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">NIP 2</label>
                                    <div class="mt-2">
                                        <input type="text" name="nip2" id="nip2" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="uid" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">UID</label>
                                    <div class="mt-2">
                                        <input
                                            type="text"
                                            name="uid"
                                            id="uid"
                                            minlength="3"
                                            maxlength="3"
                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="gender" class="block text-sm/6 font-medium text-gray-900">Gender<span class="text-red-500">*</span></label>
                                    <div class="mt-2">
                                        <select id="gender" name="gender" class=" bg-gray-50 text-base border-gray-300 block w-full rounded-md border-0 py-1 pl-5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-s sm:text-sm/6">
                                            <option value="" hidden>Choose Gender</option>
                                            <option value="f">Female</option>
                                            <option value="m">Male</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="birthDate" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Birth date</label>
                                    <div class="relative max-w-sm">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                            </svg>
                                        </div>
                                        <input id="birthDate" name="birthDate" datepicker datepicker-autohide type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 pl-8  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="religion" class="block text-sm/6 font-medium text-gray-900">Religion</label>
                                    <div class="mt-2">
                                        <select id="religion" name="religion" class=" bg-gray-50 text-base border-gray-300 block w-full rounded-md border-0 py-1 pl-5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-s sm:text-sm/6">
                                            <option value="" hidden>Choose Religion</option>
                                            <option value="ISLAM">Islam</option>
                                            <option value="KRISTEN">Kristen</option>
                                            <option value="KATOLIK">Katolik</option>
                                            <option value="HINDU">Hindu</option>
                                            <option value="BUDHA">Budha</option>
                                            <option value="KONGHUCU">Konghucu</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="lastEducation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last Education</label>
                                    <div class="mt-2">
                                        <input
                                            type="text"
                                            name="lastEducation"
                                            id="lastEducation"
                                            minlength="2"
                                            maxlength="3"

                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="faculty" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Faculty</label>
                                    <div class="mt-2">
                                        <input
                                            type="text"
                                            name="faculty"
                                            id="faculty"

                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="university" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">University</label>
                                    <div class="mt-2">
                                        <input type="text" name="university" id="university" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full    dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                </div>
                                <div class="sm:col-span-3">
                                    <label for="workLocation" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Work Location</label>
                                    <div class="mt-2">
                                        <input
                                            type="text"
                                            name="workLocation"
                                            id="workLocation"

                                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    </div>
                                </div>

                                <div class="sm:col-span-3">
                                    <label for="tmt" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> TMT<span class="text-red-500">*</span></label>
                                    <div class="relative max-w-sm">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                            </svg>
                                        </div>
                                        <input id="tmt" name="tmt" datepicker datepicker-autohide type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 pl-8 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                    </div>


                                </div>
                                <div class="sm:col-span-3">
                                    <label for="employeeAdditionalEd" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End Date</label>
                                    <div class="relative max-w-sm">
                                        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                            <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                            </svg>
                                        </div>
                                        <input id="employeeAdditionalEd" name="employeeAdditionalEd" datepicker datepicker-autohide type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 pl-8 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                    </div>


                                </div>
                                <div class="sm:col-span-full">

                                    <label for="employeeAdditionalRemark" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                                    <textarea name="employeeAdditionalRemark" id="employeeAdditionalRemark" rows="4" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your Description here..."></textarea>

                                </div>


                            </div>

                        </div>

                        <!-- Educational and Professional Background Tab -->
                        <div class="hidden p-4 bg-white rounded-lg dark:bg-gray-800" id="epb" role="tabpanel" aria-labelledby="epb-tab">
                            <div class="border-b border-gray-900/10 pb-12">
                                <h2 class="text-base/7 font-semibold text-gray-900">Assign Title</h2>


                                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-3">
                                        <label for="costCenterId" class="block text-sm/6 font-medium text-gray-900"> Cost Center<span class="text-red-500">*</span></label>
                                        <div class="mt-2">
                                            <select id="costCenterId" name="costCenterId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 ">
                                                <option value="">
                                                    N/A
                                                </option>
                                                @foreach ($costCenters as $costCenter)
                                                <option value="{{ $costCenter->cost_center }}">
                                                    {{ $costCenter->cost_center . ' | ' . $costCenter->cost_center_name }}
                                                </option>
                                                @endforeach

                                            </select>
                                        </div>
                                    </div>

                                    <div class="sm:col-span-3">
                                        <label for="titleId" class="block text-sm/6 font-medium text-gray-900"> Title<span class="text-red-500">*</span></label>
                                        <div class="mt-2">
                                            <select id="titleId" name="titleId"
                                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                                <option value="">Select a title</option>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="sm:col-span-full" id="typeHead">

                                    </div>
                                    <div class="sm:col-span-full">
                                        <label for="mapEmployeeTitleWorkStatus" class="block text-sm/6 font-medium text-gray-900">Work Status<span class="text-red-500">*</span></label>
                                        <div class="mt-2">
                                            <select id="mapEmployeeTitleWorkStatus" name="mapEmployeeTitleWorkStatus" class=" bg-gray-50 text-base border-gray-300 block w-full rounded-md border-0 py-1 pl-5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-s sm:text-sm/6">
                                                <option value="" hidden>Choose Status</option>
                                                <option value="B&B">B&B</option>
                                                <option value="DIREKSI">DIREKSI</option>
                                                <option value="PROBATION">PROBATION</option>
                                                <option value="TKJP">TKJP</option>
                                                <option value="PWT">PWT</option>
                                                <option value="PWTT">PWTT</option>
                                                <option value="PWTT(AP)">PWTT(AP)</option>
                                                <option value="PWTT(PERSERO)">PWTT(PERSERO)</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label for="mapEmployeeTitleSd" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white"> Start Date<span class="text-red-500">*</span></label>
                                        <div class="relative max-w-sm">
                                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                </svg>
                                            </div>
                                            <input id="mapEmployeeTitleSd" name="mapEmployeeTitleSd" datepicker datepicker-autohide type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 pl-8 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                        </div>

                                    </div>
                                    <div class="sm:col-span-3">
                                        <label for="mapEmployeeTitleEd" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End Date</label>
                                        <div class="relative max-w-sm">
                                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                                    <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                                </svg>
                                            </div>
                                            <input id="mapEmployeeTitleEd" name="mapEmployeeTitleEd" datepicker datepicker-autohide type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 pl-8  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                        </div>


                                    </div>
                                    <div class="sm:col-span-full">
                                        <label for="mapEmployeeTitleRemark" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                            Remark<span id="remarkRequired" class="text-red-500">*</span>
                                        </label>
                                        <textarea
                                            name="mapEmployeeTitleRemark"
                                            id="mapEmployeeTitleRemark"
                                            rows="4"
                                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                            placeholder="Write your Description here..."></textarea>
                                    </div>

                                </div>
                            </div>
                            <div class="mt-6 flex items-center justify-end gap-x-6">
                                <a href="{{route('employee')}}" class="text-sm/6 font-semibold text-gray-900">Cancel</a>
                                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                            </div>
                        </div>
                    </div>

                </form>







            </div>






        </x-slot:content>
    </x-layout>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const dateInput = document.getElementById('mapEmployeeTitleEd');
            const remarkTextarea = document.getElementById('mapEmployeeTitleRemark');
            const remarkRequired = document.getElementById('remarkRequired');

            function updateRemarkRequirement() {
                if (dateInput.value.trim() !== '') {
                    remarkTextarea.setAttribute('required', 'required');
                    remarkRequired.style.display = 'inline';
                } else {
                    remarkTextarea.removeAttribute('required');
                    remarkRequired.style.display = 'none';
                }
            }

            // Add event listeners for different scenarios that might change the date input
            dateInput.addEventListener('change', updateRemarkRequirement);
            dateInput.addEventListener('input', updateRemarkRequirement);
            dateInput.addEventListener('blur', updateRemarkRequirement);

            // Initial check
            updateRemarkRequirement();
        });
    </script>

    <script>
        $(document).ready(function() {
            const $costCenterDropdown = $('#costCenterId');
            const $titleDropdown = $('#titleId');

            if (!$costCenterDropdown.length || !$titleDropdown.length) {
                console.error("Dropdown elements not found.");
                return;
            }

            // Initialize Select2 with styling that matches your Tailwind classes
            $costCenterDropdown.select2({
                placeholder: "N/A",
                allowClear: true,
                width: '100%',
                theme: 'default',
                selectionCssClass: 'bg-gray-50 text-gray-900 text-sm dark:bg-gray-700 dark:text-white',
                dropdownCssClass: 'bg-gray-50 text-gray-900 text-sm dark:bg-gray-700 dark:text-white'
            });

            $titleDropdown.select2({
                placeholder: "Select a title",
                allowClear: true,
                width: '100%',
                theme: 'default',
                escapeMarkup: function(markup) {
                    return markup; // Let our custom formatter work
                },
                templateResult: formatTitle,
                templateSelection: formatTitle,
                selectionCssClass: 'bg-gray-50 text-gray-900 text-sm dark:bg-gray-700 dark:text-white',
                dropdownCssClass: 'bg-gray-50 text-gray-900 text-sm dark:bg-gray-700 dark:text-white'
            });

            function formatTitle(item) {
                if (!item.id) return item.text; // Return placeholder text

                const title = titlesData.find(t => t.title_id == item.id);
                if (title && title.m_title.is_head) {
                    return $(`<span class="head-title">${title.m_title.title_name} </span>`);
                }
                return item.text;
            }
            $('<style>')
                .text(`
        .select2-results__option .head-title {
            display: block;
            width: 100%;
            background-color: #e6f3ff;
            padding: 4px ;
            
        }
        .select2-container--default .select2-results__option--highlighted[aria-selected] .head-title {
            background-color: #2684ff;
        }
    `)
                .appendTo('head');

            // Listen for changes in the Cost Center dropdown
            let titlesData = []; // Store the fetched titles data globally

            $costCenterDropdown.on('change', function() {
                const selectedCostCenter = $(this).val();

                // Clear and reset the Title dropdown
                $titleDropdown.empty().append('<option value="">Select a title</option>');
                $titleDropdown.trigger('change');

                if (!selectedCostCenter) return;

                // Fetch titles for the selected cost center
                $.ajax({
                    url: `/tkyc/fetch-titles/${selectedCostCenter}`,
                    method: 'GET',
                    success: function(data) {
                        console.log('Fetched titles:', data);
                        titlesData = data; // Store the data globally

                        data.forEach(item => {
                            const titleName = item.m_title.is_head ?
                                `${item.m_title.title_name} <strong>(HEAD)</strong>` :
                                item.m_title.title_name;

                            const option = new Option(titleName, item.title_id, false, false);
                            $titleDropdown.append(option);
                        });

                        $titleDropdown.trigger('change');
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching titles:', error);
                        alert('An error occurred while fetching titles. Please try again.');
                    }
                });
            });

            $('#titleId').on('change', function() {
                const selectedTitleId = $(this).val();
                console.log('Selected Title ID:', selectedTitleId);

                // Find the selected title in the stored data
                const selectedTitle = titlesData.find(item => item.title_id == selectedTitleId);
                console.log('Selected Title:', selectedTitle);

                // Check if title is head position from m_title relationship
                if (selectedTitle && selectedTitle.m_title && selectedTitle.m_title.is_head) {
                    const selectDropdown = `
            <label for="mapEmployeeTitleType" class="block text-sm/6 font-medium text-gray-900">
                Type<span class="text-red-500">*</span>
            </label>
            <div class="mt-2">
                <select id="mapEmployeeTitleType" required name="mapEmployeeTitleType" 
                    class="bg-gray-50 text-base border-gray-300 block w-full rounded-md border-0 py-1 pl-5 
                           text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 
                           focus:ring-inset focus:ring-indigo-600 sm:max-w-s sm:text-sm/6">
                    <option value="" hidden>Choose Type</option>
                    <option value="DEFINITIVE">Definitive</option>
                    <option value="PLT">PLT</option>
                    <option value="PJS">PJS</option>
                </select>
            </div>
        `;

                    // Clear the container first and append new dropdown
                    $('#typeHead').empty().append(selectDropdown);
                } else {
                    // If the selected title is not head, remove the select dropdown
                    $('#typeHead').empty();
                }
            });
        });
    </script>
    <script>
        // Generic function to handle input transformation and cursor position
        function handleInputTransformation(elementId, regex) {
            const element = document.getElementById(elementId);
            element.value = element.value.trim();
            element.addEventListener('input', function() {
                const cursorPosition = this.selectionStart; // Save cursor position
                const originalLength = this.value.length; // Save original length

                // Transform input based on the regex
                this.value = this.value.toUpperCase().replace(regex, '');

                // Restore cursor position
                const newLength = this.value.length;
                const positionShift = newLength - originalLength;
                this.setSelectionRange(cursorPosition - positionShift, cursorPosition - positionShift);
            });
        }

        // Applying the function to all inputs
        handleInputTransformation('ktp', /[^0-9]/g);
        handleInputTransformation('npwp', /[^0-9]/g);
        handleInputTransformation('uid', /[^A-Z]/g);
        handleInputTransformation('fullName', /[^A-Z\s]/g);
        handleInputTransformation('email', /[^A-Z0-9!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?`~]/g);
        handleInputTransformation('phoneNumber', /[^0-9+]/g);
        handleInputTransformation('university', /[^A-Z0-9\s]/g);
        handleInputTransformation('partnerExternal', /[^A-Z0-9]/g);
        handleInputTransformation('lastEducation', /[^A-Z0-9\s]/g);
        handleInputTransformation('faculty', /[^A-Z\s]/g);
        handleInputTransformation('workLocation', /[^A-Z\s]/g);
        handleInputTransformation('address', /[^A-Z0-9\s,]/g);
        handleInputTransformation('employeeAdditionalRemark', /[^A-Z0-9\s]/g);
        handleInputTransformation('mapEmployeeTitleRemark', /[^A-Z0-9!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?`~\s]/g);
    </script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector("form");

            // Field labels mapping (for better user feedback)
            const fieldLabels = {
                'fullName': 'Full Name',
                'email': 'Email',
                'ktp': 'KTP Number',
                'npwp': 'NPWP Number',
                'address': 'Address',
                'partnerExternal': 'Partner External',
                'gender': 'Gender',
                'tmt': 'TMT',
                'costCenterId': 'Cost Center',
                'titleId': 'Title',
                'mapEmployeeTitleWorkStatus': 'Work Status',
                'mapEmployeeTitleSd': 'Start Date'
            };

            // Define required fields by their IDs for each tab
            const requiredFields = {
                'ge': ['fullName', 'email', 'ktp', 'npwp', 'address'],
                'ei': ['partnerExternal', 'gender', 'tmt'],
                'epb': ['costCenterId', 'titleId', 'mapEmployeeTitleWorkStatus', 'mapEmployeeTitleSd']
            };

            // Function to get missing fields
            function getMissingFields() {
                const missingFields = {};

                for (const [panelId, fields] of Object.entries(requiredFields)) {
                    const panelMissing = fields.filter(fieldId => {
                        const field = document.getElementById(fieldId);
                        return field && !field.value.trim();
                    });

                    if (panelMissing.length > 0) {
                        missingFields[panelId] = panelMissing;
                    }
                }

                return missingFields;
            }

            // Function to format missing fields message
            function formatMissingFieldsMessage(missingFields) {
                const panelNames = {
                    'ge': 'General',
                    'ei': 'Employee Info',
                    'epb': 'Employment'
                };

                let message = '<div class="text-left text-sm">'; // Added text-sm class
                message += '<p class="text-sm mb-2">Please fill in the following required fields:</p>'; // Reduced size and margin

                for (const [panelId, fields] of Object.entries(missingFields)) {
                    message += `<div class="mb-2">`; // Reduced margin
                    message += `<strong class="text-blue-600">${panelNames[panelId]}: </strong>`;
                    message += fields.map(fieldId => fieldLabels[fieldId]).join(', ');
                    message += '</div>';
                }

                message += '</div>';
                return message;
            }

            form.addEventListener("submit", async function(e) {
                e.preventDefault();

                const missingFields = getMissingFields();
                const hasErrors = Object.keys(missingFields).length > 0;

                if (hasErrors) {
                    // Get the first panel and field with an error
                    const firstPanelId = Object.keys(missingFields)[0];
                    const firstFieldId = missingFields[firstPanelId][0];
                    const firstField = document.getElementById(firstFieldId);

                    // Show error message with missing fields
                    await Swal.fire({
                        icon: "warning",
                        title: "Missing Required Fields",
                        html: formatMissingFieldsMessage(missingFields),
                        confirmButtonText: 'Got it',
                        confirmButtonColor: '#3085d6',
                        customClass: {
                            container: 'missing-fields-alert',
                            popup: 'rounded-lg',
                            title: 'text-base text-gray-700 font-semibold', // Reduced title size
                            content: 'mt-2', // Reduced top margin
                            confirmButton: 'px-4 py-1.5 rounded-lg text-sm' // Smaller button
                        }
                    });

                    // Switch to tab with error
                    const tabButton = document.querySelector(
                        `[data-tabs-target="#${firstPanelId}"]`
                    );

                    if (tabButton) {
                        tabButton.click();
                        setTimeout(() => {
                            if (firstField) {
                                firstField.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'center'
                                });
                                firstField.focus();
                            }
                        }, 100);
                    }

                    // Add visual indication for all missing fields
                    for (const [panelId, fields] of Object.entries(missingFields)) {
                        fields.forEach(fieldId => {
                            const field = document.getElementById(fieldId);
                            if (field) {
                                field.classList.add('border-red-500');
                            }
                        });
                    }
                } else {
                    // No errors - submit the form
                    this.submit();
                }
            });

            // Remove error styling when field is filled
            for (const fields of Object.values(requiredFields)) {
                fields.forEach(fieldId => {
                    const field = document.getElementById(fieldId);
                    if (field) {
                        field.addEventListener('input', function() {
                            if (this.value.trim()) {
                                this.classList.remove('border-red-500');
                            }
                        });
                    }
                });
            }
        });
    </script>



</body>

</html>