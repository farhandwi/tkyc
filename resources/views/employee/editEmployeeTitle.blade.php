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
                                    {{$mapEmployeeTitle->mTitle->title_name}}
                                </h2>
                                <!-- Title ID -->
                                <p class="mt-2 text-lg text-gray-500">
                                    {{$mapEmployeeTitle->mTitle->title_id}}
                                </p>
                            </div>
                            <!-- Is Head -->
                            <div class="text-right">
                                <span class="text-lg font-semibold text-gray-700 dark:text-gray-300">
                                    @if ($mapEmployeeTitle->mTitle->is_head)
                                    <mark class="px-2 text-white bg-blue-600 rounded dark:bg-blue-500 text-xl">Head</mark>
                                    @else
                                    Not Head
                                    @endif
                                </span>

                            </div>
                        </div>

                        <!-- Tab Buttons -->


                        <!-- Tab Content -->
                        <div id="fullWidthTabContent" class="border-t border-gray-200 dark:border-gray-600">
                            <!-- General Information Tab -->

                            <div class="grid grid-cols-2 gap-4">
                                <div class="flex flex-col">
                                    <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Name</dt>
                                    <dd class="text-base font-semibold"><span>{{$mapEmployeeTitle->mTitle->title_name}}</span></dd>
                                </div>
                                <div class="flex flex-col">
                                    <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Id</dt>
                                    <dd class="text-base font-semibold"><span>{{$mapEmployeeTitle->mTitle->title_id}}</span></dd>
                                </div>
                                <div class="flex flex-col">
                                    <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Status</dt>
                                    <dd class="text-base font-semibold"><span>{{$mapEmployeeTitle->status_pekerjaan}}</span></dd>
                                </div>
                                <div class="flex flex-col">
                                    <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Tipe</dt>
                                    <dd class="text-base font-semibold"><span>{{$mapEmployeeTitle->type}}</span></dd>
                                </div>
                                <div class="flex flex-col">
                                    <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Start Date</dt>
                                    <dd class="text-base font-semibold"><span>{{ \Carbon\Carbon::parse($mapEmployeeTitle->start_effective_date)->format('d-M-Y')  }}</span></dd>
                                </div>
                                <div class="flex flex-col">
                                    <dt class="mb-1 text-gray-500 md:text-base dark:text-gray-400">Cost Center</dt>
                                    <dd class="text-base font-semibold"><span>{{$mapEmployeeTitle->mapCostCenterHierarchy->cost_center .' | '
                                           . $mapEmployeeTitle->mapCostCenterHierarchy->cost_center_name}}</span></dd>
                                </div>

                            </div>

                            <hr class="h-px my-8 bg-gray-200 border-0 dark:bg-gray-700">
                            <form autocomplete="off" method="post" action="{{route('employeeTitleUpdate')}}">
                                @csrf
                                <div class="grid grid-cols-6 gap-4">
                                    <div class="col-span-3">
                                        <label for="mapEmployeeTitleEd" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">End Date</label>
                                        <div class="relative max-w-sm">
                                            <input id="mapEmployeeTitleEd" value="{{$mapEmployeeTitle->end_effective_date}}" name="mapEmployeeTitleEd" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                        </div>
                                    </div>
                                    <div class="col-span-3">
                                        <label for="remark" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                                        <textarea name="remark" id="remark" rows="2" class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Write your Description here...">{{ $mapEmployeeTitle->remark  }}</textarea>
                                    </div>

                                </div>
                                <input type="text" hidden name="bp" value="{{$mapEmployeeTitle->BP}}">
                                <input type="text" hidden name="costCenterId" value="{{$mapEmployeeTitle->cost_center}}">
                                <input type="text" hidden name="titleId" value="{{$mapEmployeeTitle->title_id}}">
                                <input type="text" hidden name="seqNumber" value="{{$mapEmployeeTitle->seq_nbr}}">


                        </div>

                        <!-- Modal Footer -->
                        <div class="flex items-center justify-end p-4 ">
                            <div class="mt-6 flex items-center justify-end gap-x-6">
                                <a href="{{route('employeeUpdate',['id'=>$mapEmployeeTitle->BP])}}" class="text-sm/6 font-semibold text-gray-900">Cancel</a>
                                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
                <script>
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
                    handleInputTransformation('remark', /[^A-Z0-9!@#$%^&*()_+\-=[\]{};':"\\|,.<>/?`~\s]/g);
                </script>
            </body>

            </html>

        </x-slot:content>
    </x-layout>

</body>

</html>