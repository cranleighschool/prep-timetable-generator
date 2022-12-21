<!doctype html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>
        {{ config('app.name') }}
    </title>
    <style>
        ul.two-columns {
            columns: 2;
            -webkit-columns: 2;
            -moz-columns: 2;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row p-3">
        <div class="col">
            <h1>{{ config('app.name') }}</h1>
            <p class="lead">This application uses the logic from <a href="{{ asset('Lent Prep Timetable 2022-23.pdf') }}" target="_blank">Mr Hardy's Prep Timetable sheet</a> to auto-populate your
                Prep Timetable.</p>
        </div>
    </div>
    <main>
        @foreach ($errors->all() as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
        @yield('content')
        @if (!request()->routeIs('start'))
            <div class="row p-3">
                <div class="col">
                    <a href="javascript:history.back()" class="btn btn-lg btn-primary">Go Back</a>
                    <a href="{{ url('/') }}" class="btn btn-lg btn-secondary">Start Over</a>
                </div>

            </div>
        @endif
    </main>
</div>
<footer>
    <div class="container">
        <div class="row p-3">
            <div class="col float-end">
                <small class="float-end">Questions / Errors / Comments - Please contact Mr Bradley (<a href="mailto:frb@cranleigh.org">frb@cranleigh.org</a>) or your HM. </small>
            </div>
        </div>
    </div>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
        crossorigin="anonymous"></script>
<script src="{{ asset('js/app.js') }}" />
@stack('scripts')
</body>
</html>
