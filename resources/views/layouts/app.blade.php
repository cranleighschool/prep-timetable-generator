<!doctype html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>
        Timetable
    </title>
    <style>

        ul.two-columns {
            columns: 2;
            -webkit-columns: 2;
            -moz-columns: 2;
        }
        /*main {*/
        /*    margin-top:30px;*/
        /*}*/
        /*.progress {*/
        /*    margin-bottom: 50px;*/
        /*}*/
        /*.card {*/
        /*    margin-bottom: 50px;*/
        /*}*/
    </style>
</head>
<body>
<div class="container">
    <main>
    @foreach ($errors->all() as $error)
        <div class="alert alert-danger">{{ $error }}</div>
    @endforeach
    @yield('content')
    </main>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
        crossorigin="anonymous"></script>
</body>
</html>
