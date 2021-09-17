<!doctype html>
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css"
          integrity="sha384-F3w7mX95PdgyTmZZMECAngseQB83DfGTowi0iMjiWaeVhAn4FJkqJByhZMI3AhiU" crossorigin="anonymous">
    <title>
        Timetable
    </title>
</head>
<body>
<div class="container">

    <form class="form-inline" method="POST">
        {{ csrf_field() }}
        {{ method_field('POST') }}
        <div class="row">
            <div class="col">
                <label class="form-label" for="science_set">Science Set</label>
                <input type="text" class="form-control" value="{{ old('science_set') ?? $request->science_set }}"
                       placeholder="Science Set"
                       name="science_set" id="science_set"/>

                <label class="form-label" for="maths_set">Maths Set</label>
                <input class="form-control" type="text" value="{{ old('maths_set') ?? $request->maths_set }}"
                       placeholder="Maths Set"
                       name="maths_set" id="maths_set"/>
            </div>
            <div class="col">
                <label class="form-label" for="optiona">Option A</label>
                <input class="form-control" type="text" value="{{ old('optiona') ?? $request->optiona }}"
                       placeholder="Option A" name="optiona"/>

                <label class="form-label" for="optionb">Option B</label>
                <input class="form-control" type="text" value="{{ old('optionb') ?? $request->optionb }}"
                       placeholder="Option B"
                       name="optionb"/>

                <label class="form-label" for="optionc">Option C</label>
                <input class="form-control" type="text" value="{{ old('optionc') ?? $request->optionc }}"
                       placeholder="Option C"
                       name="optionc"/>
            </div>
            <div class="col">
                <label class="form-label" for="cmlf">CMFL</label>
                <input class="form-control" type="text" value="{{ old('cmfl') ?? $request->cmfl }}" placeholder="CMFL"
                       name="cmfl"/>

                <label class="form-label" for="latin">
                    <span class="">Do you do Latin?</span>
                    <select class="form-select mt-1 block w-full" placeholder="Thingy" name="latin">
                        <option value="YES">Yes</option>
                        <option value="NO">No</option>
                    </select>
                </label>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <input class="btn-lg btn btn-block btn-primary" value="Generate Timetable" type="submit">
            </div>
        </div>
    </form>
</div>
<hr/>
<div class="container">
    <table class="table">
        <thead>
        @foreach ($timetable as $day => $values)
            <th>{{ $day }}</th>
        @endforeach
        </thead>
        <tbody>
        <tr>
            @foreach ($timetable as $day => $subjects)
                <td>
                    <table class="table">
                        <tbody>
                        @foreach ($subjects as $subject)
                            <tr>
                                <td>{{ $subject }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </td>
            @endforeach
        </tr>
        </tbody>
    </table>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-/bQdsTh/da6pkI1MST/rWKFNjaCP5gBSY4sEBT38Q/9RBh9AH40zEOg7Hlq2THRZ"
        crossorigin="anonymous"></script>
</body>
</html>
