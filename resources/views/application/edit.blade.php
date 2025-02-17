<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application</title>
    <link rel="icon" href="/images/favicon-tugu.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
</head>

<body>
    <x-layout :imageData="$imageData ?? ''" :namaUser="$namaUser">
        <x-slot:content>
            <x-page-template>
                <x-slot:pageTitle>Edit Title</x-slot:pageTitle>
            </x-page-template>


            @if (session('error'))
            <div class="p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <span class="font-medium">Error alert!</span>{{ session('error') }}
            </div>
            @endif

            <form autocomplete="off" method="post" action="{{route('applicationUpdate', ['id' => $application->app_id])}}">
                @csrf
                <div class="space-y-12">

                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base/7 font-semibold text-gray-900">Attribute Information</h2>
                        <p class="mt-1 text-sm/6 text-gray-600">Use a unique Id when creating a new Application.</p>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="appId" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Id <span class="text-red-500">*</span></label>
                                <input type="text" id="appId" name="appId" minlength="5" maxlength="5" pattern=".{5}" title="Must be exactly 5 characters" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    value="{{$application->app_id}}" placeholder="Enter 10 characters" disabled />
                                <small class="text-gray-600 dark:text-gray-400">The unique identifier for a Application, exactly 5 characters.</small>

                            </div>
                            <div class="sm:col-span-3">
                                <label for="appName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name<span class="text-red-500">*</span></label>
                                <input type="text" id="appName" name="appName" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    value="{{$application->app_name}}" placeholder="Application Name" required />
                                @error('appName')
                                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                                @enderror
                                <small class="text-gray-600 dark:text-gray-400">The name for the Application</small>

                            </div>
                            <div class="sm:col-span-3">
                                <label for="appUrl" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">URL<span class="text-red-500">*</span></label>
                                <input type="text" id="appUrl" name="appUrl" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    value="{{$application->app_url}}" placeholder="Application URL" value="https://" required />
                                <small class="text-gray-600 dark:text-gray-400">The name for the Application URL</small>

                            </div>
                            <div class="sm:col-span-3">
                                <label for="imgUrl" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Image URL<span class="text-red-500">*</span></label>
                                <input type="text" id="imgUrl" name="imgUrl" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Application URL" value="{{$application->img_url??'https://'}}" />
                                <small class="text-gray-600 dark:text-gray-400">The name for the Application Image URL</small>

                            </div>
                            <div class="sm:col-span-3">
                                <label for="appEnvironment" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Environment<span class="text-red-500">*</span></label>
                                <select required id="appEnvironment" name="appEnvironment" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option value="">Choose Environment</option>
                                    <option value="110 - SIT" {{ $application->environment == '110 - SIT' ? 'selected' : '' }}>110 - SIT</option>
                                    <option value="120 - UAT" {{ $application->environment == '120 - UAT' ? 'selected' : '' }}>120 - UAT</option>
                                    <option value="300 - Live" {{ $application->environment == '300 - Live' ? 'selected' : '' }}>300 - Live</option>
                                </select>
                            </div>






                            <hr class="sm:col-span-full h-px my-8 bg-gray-200 border-0 mt-6 dark:bg-gray-700">



                            <div class="sm:col-span-3">
                                <label for="costCenterIdss" class="block text-sm font-medium text-gray-900"> Cost Centers (Multiple)<span class="text-red-500">*</span></label>
                                <div class="mt-2">
                                    <select id="costCenterIdss" name="costCenterIds[]" class="w-[25rem] cost-center-dropdown" multiple>
                                        @php
                                        $hasNoMappings = !$application->mapCostCenterApplication;
                                        $hasInvalidMappings = $application->mapCostCenterApplication?->filter(
                                        fn($map) => !$map->costCenterHierarchy
                                        )->isNotEmpty();

                                        $selectedCostCenters = $application->mapCostCenterApplication?->filter(
                                        fn($map) => $map->costCenterHierarchy
                                        )->pluck('costCenterHierarchy.cost_center')->toArray() ?? [];
                                        @endphp

                                        <option value="">Add Cost Center</option>

                                        @foreach ($costCenters as $costCenter)
                                        <option value="{{ $costCenter->cost_center }}"
                                            {{ in_array($costCenter->cost_center, $selectedCostCenters) ? 'selected' : '' }}>
                                            {{ $costCenter->cost_center . ' | ' . $costCenter->cost_center_name }}
                                        </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="employeeId" class="block text-sm font-medium text-gray-900"> BP (Multiple)<span class="text-red-500">*</span></label>
                                <div class="mt-2">
                                    <select id="employeeId" name="employeeId[]" class="w-[25rem] cost-center-dropdown" multiple>
                                        @php
                                        $hasNoEmployeeMappings = $mapEmployeeApplication->isEmpty();
                                        $hasInvalidEmployeeMappings = $mapEmployeeApplication->filter(
                                        fn($map) => !$map->mEmployeeGeneralInfo
                                        )->isNotEmpty();

                                        $selectedEmployees = $mapEmployeeApplication->filter(
                                        fn($map) => $map->mEmployeeGeneralInfo
                                        )->pluck('mEmployeeGeneralInfo.BP')->toArray() ?? [];
                                        @endphp

                                        <option value=""> Add BP</option>

                                        @foreach ($employees as $employee)
                                        <option value="{{ $employee->BP }}"
                                            {{ in_array($employee->BP, $selectedEmployees) ? 'selected' : '' }}>
                                            {{ $employee->BP . ' | ' . $employee->name }}
                                        </option>
                                        @endforeach
                                    </select>

                                </div>
                            </div>





                        </div>
                    </div>
                </div>

                <div class=" mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{route('application')}}" class="text-sm/6 font-semibold text-gray-900">Cancel</a>
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
            </form>






        </x-slot:content>
    </x-layout>

    <script>
        $(document).ready(function() {
            $('.cost-center-dropdown').select2();
        });

        document.getElementById('appName').addEventListener('input', function(e) {
            // Allow uppercase letters and spaces
            this.value = this.value.toUpperCase().replace(/[^A-Z0-9\s]+/g, '');

        });
    </script>




</body>

</html>
