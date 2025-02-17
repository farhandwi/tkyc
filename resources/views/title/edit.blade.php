<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Title</title>
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

            <form autocomplete="off" method="post" action="{{route('titleUpdate', ['id' => $title->title_id])}}">
                @csrf
                <div class="space-y-12">

                    <div class="border-b border-gray-900/10 pb-12">
                        <h2 class="text-base/7 font-semibold text-gray-900">Attribute Information</h2>

                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="mTitleId" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Id <span class="text-red-500">*</span></label>
                                <input value="{{$title->title_id}}" type="text" id="mTitleId" name="mTitleId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    disabled />


                            </div>
                            <div class="sm:col-span-3">
                                <label for="mTitleName" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Name<span class="text-red-500">*</span></label>
                                <input value="{{$title->title_name}}" type="text" id="mTitleName" name="mTitleName" minlength="3" title="Minimum 3 characters" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    placeholder="Title Name" required />
                                <small class="text-gray-600 dark:text-gray-400">The name for the Title</small>

                            </div>

                            <div class="sm:col-span-3">
                                <label for="mTitleSd" class="block text-sm/6 font-medium text-gray-900"> Start Date<span class="text-red-500">*</span></label>
                                <div class="relative max-w-sm">
                                    <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                            <path d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                        </svg>
                                    </div>
                                    <input id="mTitleSd" name="mTitleSd" value="{{ ($title->start_effective_date) }}"

                                        type="text" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date"
                                        disabled>
                                </div>


                            </div>
                            <div class="sm:col-span-3">
                                <label for="mTitleEd" class="block text-sm/6 font-medium text-gray-900"> End Date</label>
                                <div class="relative max-w-sm">

                                    <input id="mTitleEd" name="mTitleEd" value="{{ $title->end_effective_date ? \Carbon\Carbon::make($title->end_effective_date)->format('Y-m-d') : '' }}" type="date" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Select date">
                                </div>


                            </div>
                            <div class="sm:col-span-full flex justify-center">
                                <div class="flex items-center mb-4" style=" margin-left: 100px;">



                                    <!-- Checkbox input for checked state -->
                                    <input
                                        id="is_head"
                                        type="checkbox"
                                        name="mTitleIsHead"
                                        disabled
                                        value="1"
                                        class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
                                        {{ $title->is_head ? 'checked' : '' }}>

                                    <label for="is_head" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">Is Head<span class="text-red-500">*</span></label>
                                </div>
                            </div>




                            <hr class="sm:col-span-full h-px my-8 bg-gray-200 border-0 mt-6 dark:bg-gray-700">



                            <div class="sm:col-span-3">
                                <label for="costCenterIdss" class="block text-sm font-medium text-gray-900"> Cost Centers (Multiple)</label>
                                <div class="mt-2">
                                    <select id="costCenterIdss" name="costCenterIds[]" class="w-[25rem] cost-center-dropdown choices__input" multiple>
                                        <!-- <option value="">N/A</option> -->
                                        <option value=""
                                            {{ !$title->mapTitleCostCenter || $title->mapTitleCostCenter->filter(function($mapTitleCostCenter) {
            return !$mapTitleCostCenter->mapCostCenterHierarchy;
        })->isNotEmpty() ? 'selected' : '' }}>
                                            N/A
                                        </option>
                                        @foreach ($costCenters as $costCenter)
                                        <option
                                            value="{{ $costCenter->cost_center }}"
                                            {{ $title->mapTitleCostCenter && $title->mapTitleCostCenter->contains(function($mapTitleCostCenter) use ($costCenter) {
                                                return $mapTitleCostCenter->mapCostCenterHierarchy &&
                                                    $mapTitleCostCenter->mapCostCenterHierarchy->cost_center === $costCenter->cost_center;
                                            }) ? 'selected' : '' }}>
                                            {{ $costCenter->cost_center . ' | ' . $costCenter->cost_center_name }}
                                        </option>

                                        @endforeach
                                    </select>

                                </div>
                            </div>

                            <div class="sm:col-span-3">
                                <label for="postal-code" class=" block text-sm/6 font-medium text-gray-900">Grade (Multiple)</label>
                                <div class="mt-2">

                                    <select id="Titlegrades" name="Titlegrades[]" class="w-[25rem] cost-center-dropdown choices__input" multiple>
                                        <!-- N/A Option -->
                                        <option value=""
                                            {{ !$title->mapTitleGrade->filter(function($mapTitleGrade) {
                                            return !$mapTitleGrade->grade_id;
                                        })->isEmpty() ? 'selected' : '' }}>
                                            N/A
                                        </option>

                                        <!-- Loop through grades and set selected options -->
                                        @foreach ($grades as $key => $value)
                                        <option value="{{ $key }}"
                                            {{ $title->mapTitleGrade->contains(function($mapTitleGrade) use ($key) {
                                            return $mapTitleGrade->grade_id == $key;
                                        }) ? 'selected' : '' }}>
                                            {{ $key }}
                                        </option>
                                        @endforeach
                                    </select>



                                </div>
                            </div>




                        </div>
                    </div>
                </div>

                <div class=" mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{route('title')}}" class="text-sm/6 font-semibold text-gray-900">Cancel</a>
                    <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
            </form>






        </x-slot:content>
    </x-layout>

    <script>
        function handleInputTransformation(elementId, regex) {
            const element = document.getElementById(elementId);
            element.value = element.value.trim();
            element.addEventListener('input', function() {
                const cursorPosition = this.selectionStart; // Save cursor position
                const originalLength = this.value.length; // Save original length

                // Transform input based on the regex
                if (regex) {
                    // Transform input to uppercase and remove invalid characters based on regex
                    this.value = this.value.toUpperCase().replace(regex, '');
                } else {
                    // If no regex, just transform input to uppercase without removing anything
                    this.value = this.value.toUpperCase();
                }

                // Restore cursor position
                const newLength = this.value.length;
                const positionShift = newLength - originalLength;
                this.setSelectionRange(cursorPosition - positionShift, cursorPosition - positionShift);
            });
        }
        handleInputTransformation('mTitleName', /[^A-Z\s]+/g);
        $(document).ready(function() {
            $('.cost-center-dropdown').select2();
        });
    </script>


</body>

</html>
