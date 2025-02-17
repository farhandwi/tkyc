<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Cost Center Hierarchy</title>
    <link rel="icon" href="/images/favicon-tugu.png" type="image/x-icon">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
</head>

<body>
    <x-layout :imageData="$imageData ?? ''" :namaUser="$namaUser">
        <x-slot:content>
            <x-page-template>
                <x-slot:pageTitle>Create Cost Center Hierarchy</x-slot:pageTitle>
            </x-page-template>

            <form autocomplete="off" method="post" action="{{route('costCenterHierarchyStore')}}">
                @csrf
                <div class="space-y-12">

                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base/7 font-semibold text-gray-900">Attribute Information</h2>
                        <p class="mt-1 text-sm/6 text-gray-600">Use a unique Id when creating a new Cost Center Hierarchy.</p>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <!-- <div class="sm:col-span-3">
                                <label for="costCenterId" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Id <span class="text-red-500">*</span></label>
                                <input type="text" id="costCenterId" name="costCenterId" minlength="10" maxlength="10" pattern=".{10}" title="Must be exactly 10 characters" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Enter 10 characters" required />
                                <small class="text-gray-600 dark:text-gray-400">The unique identifier for a cost center Hierarchy, exactly 10 characters.</small>

                            </div> -->
                            <div class="sm:col-span-full">
                                <label for="costCenterId" class="block text-sm/6 font-medium text-gray-900">Cost Center</label>
                                <div class="mt-2">
                                    <select id="costCenterId" name="costCenterId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cost-center-dropdown">
                                        <option value=""> N/A</option>

                                        @foreach ($distinctCostCenters as $costCenter)
                                        <option value="{{ $costCenter->cost_ctr }}">
                                            {{ $costCenter->cost_ctr . ' | ' . $costCenter->ct_description }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>


                            <div class="sm:col-span-3">
                                <label for="costCenterSd" class="block text-sm/6 font-medium text-gray-900"> Start Date<span class="text-red-500">*</span></label>
                                <div class="relative max-w-sm">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input id="costCenterSd" name="costCenterSd" datepicker datepicker-autohide type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 pl-8  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date"
                                        required>
                                </div>


                            </div>
                            <div class="sm:col-span-3">
                                <label for="costCenterEd" class="block text-sm/6 font-medium text-gray-900"> End Date</label>
                                <div class="relative max-w-sm">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input id="costCenterEd" name="costCenterEd" datepicker datepicker-autohide type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 pl-8 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                </div>


                            </div>


                            <hr class="sm:col-span-full h-px my-8 bg-gray-200 border-0 mt-6 dark:bg-gray-700">



                            <div class="sm:col-span-3">
                                <label for="costCenterDrId" class="block text-sm/6 font-medium text-gray-900"> Direct Report</label>
                                <div class="mt-2">
                                    <select id="costCenterDrId" name="costCenterDrId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cost-center-dropdown">
                                        <option value=""> N/A</option>
                                        <option value="self">SELF</option>
                                        @foreach ($costCenters as $costCenter)
                                        <option value="{{ $costCenter->cost_center }}">
                                            {{ $costCenter->cost_center . ' | ' . $costCenter->cost_center_name }}
                                        </option>
                                        @endforeach


                                    </select>
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="costCenterCpId" class="block text-sm/6 font-medium text-gray-900">POSS</label>
                                <div class="mt-2">
                                    <select id="costCenterCpId" name="costCenterCpId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cost-center-dropdown">
                                        <option value=""> N/A</option>
                                        <option value="self">SELF</option>
                                        @foreach ($costCenters as $costCenter)
                                        <option value="{{$costCenter->cost_center }}">{{$costCenter->cost_center.' | '.$costCenter->cost_center_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="costCenterDhId" class="block text-sm/6 font-medium text-gray-900"> Departement Head</label>
                                <div class="mt-2">
                                    <select id="costCenterDhdId" name="costCenterDhId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cost-center-dropdown">
                                        <option value=""> N/A</option>
                                        <option value="self">SELF</option>
                                        @foreach ($costCenters as $costCenter)
                                        <option value="{{$costCenter->cost_center }}">{{$costCenter->cost_center.' | '.$costCenter->cost_center_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="sm:col-span-3">
                                <label for="costCenterGhId" class="block text-sm/6 font-medium text-gray-900">Group Head</label>
                                <div class="mt-2">
                                    <select id="costCenterGhId" name="costCenterGhId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cost-center-dropdown">
                                        <option value=""> N/A</option>
                                        <option value="self">SELF</option>
                                        @foreach ($costCenters as $costCenter)
                                        <option value="{{$costCenter->cost_center }}">{{$costCenter->cost_center.' | '.$costCenter->cost_center_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="costCenterSvpId" class="block text-sm/6 font-medium text-gray-900">Senior Vice President</label>
                                <div class="mt-2">
                                    <select id="costCenterSvpId" name="costCenterSvpId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cost-center-dropdown">
                                        <option value=""> N/A</option>
                                        <option value="self">SELF</option>
                                        @foreach ($costCenters as $costCenter)
                                        <option value="{{$costCenter->cost_center }}">{{$costCenter->cost_center.' | '.$costCenter->cost_center_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="sm:col-span-full">
                                <label for="costCenterDirId" class="block text-sm/6 font-medium text-gray-900">Director</label>
                                <div class="mt-2">
                                    <select id="costCenterDirId" name="costCenterDirId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cost-center-dropdown">
                                        <option value=""> N/A</option>
                                        <option value="self">SELF</option>
                                        @foreach ($costCenters as $costCenter)
                                        <option value="{{$costCenter->cost_center }}">{{$costCenter->cost_center.' | '.$costCenter->cost_center_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{route('costCenterHierarchy')}}" class="text-sm/6 font-semibold text-gray-900">Cancel</a>
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
            </form>






        </x-slot:content>
    </x-layout>
    <script>
        $(document).ready(function() {
            $('.cost-center-dropdown').select2();
        });
    </script>

    <script>

    </script>


</body>

</html>
