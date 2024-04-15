<!doctype html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />
    <title>
        {{ config('app.name') }}
    </title>
    <style>
        ul.two-columns {
            columns: 2;
            -webkit-columns: 2;
            -moz-columns: 2;
        }

        @media print {
            div {
                break-inside: avoid;
            }

            .container {
                width: 100% !important;
            }
        }
    </style>
</head>
<body class="bg-gray-100">
<div class="bg-gray-100 align-middle">
    <div class="flex flex-col justify-center items-center align-middle">
        <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-center text-blue-700 m-4 p-10">Prep Timetable Generator</h1>
        <img src="https://www.svgrepo.com/show/426192/cogs-settings.svg" alt="Logo"
             class="mb-8 h-40 align-middle items-center">
        <h2 class="text-4xl md:text-5xl lg:text-6xl font-bold text-center text-gray-700 mb-4">Site is under
            maintenance</h2>
        <p class="text-center text-gray-500 text-lg md:text-xl lg:text-2xl mb-8">The site is just regenerating all the timetables. Please hit refresh in a couple of minutes.</p>
    </div>
</div>

<script src="{{ asset('js/app.js') }}"/>
@stack('scripts')
</body>
</html>
