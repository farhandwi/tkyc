<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Title</title>
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
                                    {{$title->title_name}}
                                </h2>
                                <!-- Title ID -->
                                <p class="mt-2 text-lg text-gray-500">
                                    {{$title->title_id}}
                                </p>
                            </div>
                            <!-- Is Head -->
                            <div class="text-right">
                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                    @if ($title->is_head)
                                    <mark class="px-2 text-white bg-blue-600 rounded dark:bg-blue-500 text-xl">Head</mark>
                                    @else
                                    Not Head
                                    @endif
                                </span>

                            </div>
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
                                    Cost Center
                                </button>
                            </li>
                            <li class="w-full">
                                <button id="epb-tab" data-tabs-target="#epb" type="button" role="tab" aria-controls="epb" aria-selected="false" class="inline-block w-full p-4 rounded-se-lg bg-gray-50 hover:bg-gray-100 focus:outline-none dark:bg-gray-700 dark:hover:bg-gray-600">
                                    Grade
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
                                        <dd class="text-base font-semibold"><span>{{$title->title_name}}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Id</dt>
                                        <dd class="text-base font-semibold"><span>{{$title->title_id}}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Start Date</dt>
                                        <dd class="text-base font-semibold"><span> {{ \Carbon\Carbon::parse($title->start_effective_date)->format('d-M-Y') }}</span></dd>
                                    </div>
                                    <div class="flex flex-col">
                                        <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">End Date</dt>
                                        <dd class="text-base font-semibold"><span> {{ $title->end_effective_date 
                                            ? \Carbon\Carbon::parse($title->end_effective_date)->format('d-M-Y') 
                                            : 'N/A' }}</span></dd>
                                    </div>
                                </div>
                            </div>

                            <!-- Employment Information Tab -->
                            <div class="hidden p-4 bg-white rounded-lg md:p-8 dark:bg-gray-800" id="ei" role="tabpanel" aria-labelledby="ei-tab">
                                @if (!empty($title->mapTitleCostCenter) && $title->mapTitleCostCenter->isNotEmpty())
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($title->mapTitleCostCenter as $index => $costCenter)
                                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                        <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                        </svg>
                                        <span>
                                            {{ $costCenter->MapCostCenterHierarchy->cost_center_name }}
                                            <span class="font-semibold text-gray-900 dark:text-white">{{ $costCenter['cost_center'] }}</span>
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <p class="text-gray-500 dark:text-gray-400">No cost centers assigned.</p>
                                @endif
                            </div>

                            <!-- Educational and Professional Background Tab -->
                            <div class="hidden p-4 bg-white rounded-lg dark:bg-gray-800" id="epb" role="tabpanel" aria-labelledby="epb-tab">
                                <!-- Accordion -->
                                @if ($title->mapTitleGrade->isNotEmpty()) <!-- Check if titleGrade has items -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    @foreach ($title->mapTitleGrade as $mapTitleGrade)
                                    <div class="flex items-center space-x-3 rtl:space-x-reverse">
                                        <svg class="flex-shrink-0 w-3.5 h-3.5 text-green-500 dark:text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 16 12">
                                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5.917 5.724 10.5 15 1.5" />
                                        </svg>
                                        <span>
                                            Grade: <!-- Add your grade data here -->
                                            <span class="font-semibold text-gray-900 dark:text-white">{{ $mapTitleGrade->grade_id}}</span>
                                        </span>
                                    </div>
                                    @endforeach
                                </div>
                                @else
                                <p class="text-gray-500 dark:text-gray-400">No grades assigned.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center justify-end p-4 border-t">
                            <a href="{{route('title')}}" class="text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg text-sm px-6 py-3 text-center">
                                Back
                            </a>
                        </div>
                    </div>
                </div>

            </body>

            </html>

        </x-slot:content>
    </x-layout>

</body>

</html>
