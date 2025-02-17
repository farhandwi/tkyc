<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Cost Center</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/choices.js/public/assets/styles/choices.min.css">
    <script src="https://cdn.jsdelivr.net/npm/choices.js/public/assets/scripts/choices.min.js"></script>
    <link rel="icon" href="/images/favicon-tugu.png" type="image/x-icon">
</head>

<body>
    <x-layout :imageData="$imageData ?? ''" :namaUser="$namaUser">
        <x-slot:content>
            <x-page-template>
                <x-slot:pageTitle>Create Cost Center</x-slot:pageTitle>
            </x-page-template>

            <form autocomplete="off" method="post" action="{{ route('costCenterStore') }}">
                @csrf
                <div class="space-y-12">

                    <div class="border-b border-gray-900/10 pb-12">



                        <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                            <div class="sm:col-span-3">
                                <label for="id" class="block text-sm/6 font-medium text-gray-900"> Id
                                    (Auto-Generated)</label>
                                <input value="{{ $newId }}" type="text" id="id" name="id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                    disabled />
                            </div>
                            {{-- <div class="sm:col-span-3">
                                <label for="oldId" class="block text-sm/6 font-medium text-gray-900"> Old Id</label>
                                <div class="mt-2">
                                    <select id="oldId" name="oldId" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cost-center-dropdown">
                                        <option selected value=""> N/A</option>
                                        @foreach ($costCenters as $costCenter)
                                        <option value="{{$costCenter->id}}">{{$costCenter->id .' | '. $costCenter->cost_center_name}} </option>
                            @endforeach
                            </select>
                        </div>
                    </div> --}}
                    <div class="sm:col-span-3">
                        <label for="oldId" class="block text-sm/6 font-medium text-gray-900"> Old Id</label>
                        <div class="mt-2">
                            <select id="oldId" name="oldId"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cost-center-dropdown">
                                <option selected value=""> N/A</option>
                                @foreach ($costCenters as $costCenter)
                                <option value="{{ $costCenter->id }}">
                                    {{ $costCenter->id . ' | ' . $costCenter->ct_description }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="sm:col-span-3">
                        <label for="mergeId" class="block text-sm/6 font-medium text-gray-900"> Merge
                            Id</label>
                        <div class="mt-2">
                            <select id="mergeId" name="mergeId"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500 cost-center-dropdown">
                                <option selected value=""> N/A</option>
                                @foreach ($costCenters as $costCenter)
                                <option value="{{ $costCenter->id }}">
                                    {{ $costCenter->id . ' | ' . $costCenter->ct_description }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="sm:col-span-3">
                        <label for="prodCtr"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Production
                            Center<span class="text-red-500">*</span></label>
                        <input type="text" id="prodCtr" name="prodCtr" minlength="4" maxlength="4"
                            pattern=".{4}" title="Minimum 4 characters"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required />

                    </div>
                    <div class="sm:col-span-3">
                        <label for="costCtr"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Cost
                            Center<span class="text-red-500">*</span></label>
                        <input type="text" id="costCtr" name="costCtr" minlength="10" maxlength="10"
                            pattern=".{10}" title="Minimum 10 characters"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required />

                    </div>
                    <div class="sm:col-span-3">
                        <label for="profitCtr"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Profit
                            Center<span class="text-red-500">*</span></label>
                        <input type="text" id="profitCtr" name="profitCtr" minlength="10" maxlength="10"
                            pattern=".{10}" title="Minimum 10 characters"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required />
                    </div>
                    <div class="sm:col-span-3">
                        <label for="tmt" class="block text-sm/6 font-medium text-gray-900">TMT<span
                                class="text-red-500">*</span></label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="tmt" name="tmt" datepicker datepicker-autohide type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 pl-8  dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Select date" required>
                        </div>


                    </div>
                    <div class="sm:col-span-3">
                        <label for="expiredDate" class="block text-sm/6 font-medium text-gray-900">Expired
                            Date</label>
                        <div class="relative max-w-sm">
                            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                                <svg class="w-4 h-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M20 4a2 2 0 0 0-2-2h-2V1a1 1 0 0 0-2 0v1h-3V1a1 1 0 0 0-2 0v1H6V1a1 1 0 0 0-2 0v1H2a2 2 0 0 0-2 2v2h20V4ZM0 18a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8H0v10Zm5-8h10a1 1 0 0 1 0 2H5a1 1 0 0 1 0-2Z" />
                                </svg>
                            </div>
                            <input id="expiredDate" name="expiredDate" datepicker datepicker-autohide
                                type="text"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 pl-8 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                placeholder="Select date">
                        </div>


                    </div>
                    <div class="sm:col-span-3">
                        <label for="plant"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Plant<span
                                class="text-red-500">*</span></label>
                        <input type="text" id="plant" name="plant"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            required />
                    </div>
                    <div class="sm:col-span-3">

                        <label for="ctDescription"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Center
                            Description<span class="text-red-500">*</span></label>
                        <textarea required name="ctDescription" id="ctDescription" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Write your Description here..."></textarea>

                    </div>
                    <div class="sm:col-span-3">

                        <label for="remark"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Remark</label>
                        <textarea name="remark" id="remark" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Write your Description here..."></textarea>

                    </div>
                    <div class="sm:col-span-3">

                        <label for="skd"
                            class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">SKD</label>
                        <textarea name="skd" id="skd" rows="4"
                            class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                            placeholder="Write your Description here..."></textarea>

                    </div>




                </div>
                </div>
                </div>

                <div class="mt-6 flex items-center justify-end gap-x-6">
                    <a href="{{ route('costCenter') }}" class="text-sm/6 font-semibold text-gray-900">Cancel</a>
                    <button type="submit"
                        class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                </div>
            </form>






        </x-slot:content>
    </x-layout>

    <script>
        $(document).ready(function() {
            $('.cost-center-dropdown').select2();
        });

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
        handleInputTransformation("plant", /[^A-Z0-9\s]+/g);
        handleInputTransformation("ctDescription", null);
        handleInputTransformation("remark", null);
        handleInputTransformation("skd", null);
    </script>





</body>

</html>