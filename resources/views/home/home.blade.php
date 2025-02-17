<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="icon" href="/images/favicon-tugu.png" type="image/x-icon">


</head>

<body>
    <x-layout :imageData="$imageData ?? ''" :namaUser="$namaUser">

        <x-slot:content>
            <div class="flex flex-col items-center justify-center h-screen text-center">
                <h1 class="mb-4 text-4xl font-extrabold leading-none tracking-tight text-gray-900 md:text-2xl lg:text-3xl dark:text-white">
                    Regain <mark class="px-2 text-white bg-blue-600 rounded dark:bg-blue-500">control</mark> of Business Partner
                </h1>
                <p class="text-lg font-normal text-gray-500 lg:text-xl dark:text-gray-400">
                    At Business Partner we focus on managing our Business Partners and Titles.
                </p>
            </div>
        </x-slot:content>
    </x-layout>

</body>

</html>
