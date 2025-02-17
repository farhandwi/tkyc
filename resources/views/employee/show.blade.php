<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee Detail</title>
    <link rel="icon" href="/images/favicon-tugu.png" type="image/x-icon">
</head>

<body>
    <x-layout :imageData="$imageData ?? ''" :namaUser="$namaUser">
        <x-slot:content>
            <x-page-template>
                <x-slot:pageTitle>Title</x-slot:pageTitle>
            </x-page-template>

            <!DOCTYPE html>
            <html lang="en">

            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <title>Document</title>

            </head>

            <body class="bg-gray-100">

                <div class="fixed inset-0 z-50 bg-black bg-opacity-50 flex justify-center items-center overflow-y-auto">
                    <!-- Modal Content -->
                    <div class="relative p-10 w-full max-w-5xl bg-white rounded-lg shadow-lg overflow-y-auto max-h-screen">
                        <!-- Modal Header -->
                        <div class="flex items-center justify-between p-4 border-b">
                            <div>
                                <!-- Title Name -->
                                <h2 class="text-4xl font-extrabold dark:text-white">
                                    {{$employee->name}}
                                </h2>
                                <!-- Title ID -->
                                <p class="mt-2 text-lg text-gray-500">
                                    {{$employee->BP}}
                                </p>
                            </div>
                            <!-- Is Head -->

                        </div>

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

                        <!-- Tab Content -->
                        <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">
                            <!-- General Information Tab -->
                            <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="ge" role="tabpanel" aria-labelledby="ge-tab">
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Name</dt>
                                        <dd class="text-base font-semibold"><span>{{$employee->name}}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Email</dt>
                                        <dd class="text-base font-semibold"><span>{{$employee->email}}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Id</dt>
                                        <dd class="text-base font-semibold"><span>{{$employee->BP}}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Address</dt>
                                        <dd class="text-base font-semibold"><span>{{ $employee->address }}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Phone Number</dt>
                                        <dd class="text-base font-semibold"> <span>{{ $employee->phone_number ? $employee->phone_number : 'N/A' }}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">NPWP</dt>
                                        <dd class="text-base font-semibold"> <span>{{ $employee->NPWP ? $employee->NPWP : 'N/A' }}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">KTP</dt>
                                        <dd class="text-base font-semibold"> <span>{{ $employee->KTP ? $employee->KTP : 'N/A' }}</span></dd>
                                    </div>

                                </div>
                            </div>

                            <!-- Additional Information Tab -->
                            <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="ei" role="tabpanel" aria-labelledby="ei-tab">
                                @if (!empty($employee->mEmployeeAdditional))
                                <div class="grid grid-cols-2 gap-4">
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">NIP</dt>
                                        <dd class="text-base font-semibold"> <span>{{ $employee->mEmployeeAdditional->NIP ? $employee->mEmployeeAdditional->NIP : 'N/A' }}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">NIP 2</dt>
                                        <dd class="text-base font-semibold"> <span>{{ $employee->mEmployeeAdditional->NIP_2 ? $employee->mEmployeeAdditional->NIP_2 : 'N/A' }}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">UID</dt>
                                        <dd class="text-base font-semibold"> <span>{{ $employee->mEmployeeAdditional->UID ? $employee->mEmployeeAdditional->UID : 'N/A' }}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Religion</dt>
                                        <dd class="text-base font-semibold"> <span>{{ $employee->mEmployeeAdditional->agama ? $employee->mEmployeeAdditional->agama : 'N/A' }}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Birth Date</dt>
                                        <dd class="text-base font-semibold"> <span>{{ $employee->mEmployeeAdditional->tanggal_lahir ? $employee->mEmployeeAdditional->tanggal_lahir : 'N/A' }}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Last Education</dt>
                                        <dd class="text-base font-semibold"> <span>{{ $employee->mEmployeeAdditional->pendidikan_terakhir ? $employee->mEmployeeAdditional->pendidikan_terakhir : 'N/A' }}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Faculty</dt>
                                        <dd class="text-base font-semibold"> <span>{{ $employee->mEmployeeAdditional->fakultas ? $employee->mEmployeeAdditional->fakultas : 'N/A' }}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Universtas</dt>
                                        <dd class="text-base font-semibold"> <span>{{ $employee->mEmployeeAdditional->university ? $employee->mEmployeeAdditional->university : 'N/A' }}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Work Location</dt>
                                        <dd class="text-base font-semibold"> <span>{{ $employee->mEmployeeAdditional->lokasi_pekerjaan ? $employee->mEmployeeAdditional->lokasi_pekerjaan : 'N/A' }}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Work Status</dt>
                                        <dd class="text-base font-semibold"> <span>{{ $employee->mEmployeeAdditional->status_pekerjaan ? $employee->mEmployeeAdditional->status_pekerjaan : 'N/A' }}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Partner External</dt>
                                        <dd class="text-base font-semibold"><span>{{$employee->mEmployeeAdditional->PARTNEREXTERNAL}}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Gender</dt>
                                        <dd class="text-base font-semibold">
                                            <span>{{ $employee->mEmployeeAdditional ? ($employee->mEmployeeAdditional->is_male ? 'Male' : 'Female') : 'N/A' }}</span>
                                        </dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">TMT</dt>
                                        <dd class="text-base font-semibold"><span> {{ optional($employee->mEmployeeAdditional)->tmt 
                                        ? \Carbon\Carbon::parse(optional($employee->mEmployeeAdditional)->tmt)->format('d-M-Y') 
                                        : 'N/A' }}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">End date</dt>
                                        <dd class="text-base font-semibold"><span> {{ optional($employee->mEmployeeAdditional)->end_effective_date 
                                        ? \Carbon\Carbon::parse(optional($employee->mEmployeeAdditional)->end_effective_date)->format('d-M-Y') 
                                        : 'N/A' }}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Remark</dt>
                                        <dd class="text-base font-semibold">
                                            <span>{{ optional($employee->mEmployeeAdditional)->Remark ?? 'N/A' }}</span>
                                        </dd>
                                    </div>

                                </div>
                                @else
                                <p class="text-gray-500 dark:text-gray-400"> Employee additional information unavailable.</p>
                                @endif
                            </div>

                            <!-- Educational and Professional Background Tab -->
                            <div class="hidden p-4 bg-white rounded-lg dark:bg-gray-800" id="epb" role="tabpanel" aria-labelledby="epb-tab">
                                <!-- Accordion -->
                                @if ($employee->mapEmployeeTitle->isNotEmpty()) <!-- Check if titleGrade has items -->
                                <div class="grid grid-cols-1 md:grid-cols-1 gap-4">
                                    @foreach ($employee->mapEmployeeTitle as $mapEmployeeTitle)
                                    <ul class=" divide-y divide-gray-200 dark:divide-gray-700">
                                        <li class="pb-3 sm:pb-4">
                                            <div class=" pl-3  pr-3 flex items-center justify-between space-x-4">
                                                <div class="flex-1 min-w-0">
                                                    <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                                        {{$mapEmployeeTitle->mTitle->title_name}}
                                                        @if ($mapEmployeeTitle->mTitle->is_head)
                                                        <mark class="px-2 text-white bg-blue-600 rounded dark:bg-blue-500 text-sm">Head</mark>

                                                        @endif
                                                    </p>
                                                    <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                                        {{$mapEmployeeTitle->cost_center.' | '.$mapEmployeeTitle->mapCostCenterHierarchy->cost_center_name}}
                                                    </p>
                                                </div>
                                                <!-- Right aligned date section -->
                                                <div class="text-right">
                                                    <div class="text-base font-semibold text-gray-900 dark:text-white">
                                                        {{ $mapEmployeeTitle->start_effective_date 
                                                            ? \Carbon\Carbon::parse($mapEmployeeTitle->start_effective_date)->format('d-M-Y') 
                                                            : 'N/A' }}
                                                        <span class="text-sm mx-2 text-gray-500 truncate dark:text-gray-400">to</span>
                                                        {{ $mapEmployeeTitle->end_effective_date 
                                                            ? \Carbon\Carbon::parse($mapEmployeeTitle->end_effective_date)->format('d-M-Y') 
                                                            : 'N/A' }}
                                                    </div>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                    @endforeach
                                </div>
                                @else
                                <p class="text-gray-500 dark:text-gray-400">No Title assigned.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center justify-end p-4 border-t">
                            <a href="{{route('employee')}}" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-6 py-3 text-center">
                                Back
                            </a>
                        </div>
                    </div>
                </div>
                </div>

            </body>

            </html>

        </x-slot:content>
    </x-layout>

</body>

</html>
