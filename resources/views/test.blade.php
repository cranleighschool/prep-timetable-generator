@extends('layouts.app')
@section('content')
    <form class="form-inline" method="POST">
        {{ csrf_field() }}
        {{ method_field('POST') }}
        <div class="row">
            <div class="col"><h2>Your Subjects</h2>
            <ul>
                @foreach ($sets as $code => $subject)
                    <li>{{ $subject }} (<code>{{ $code }}</code>)</li>
                    @endforeach
            </ul>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <label class="form-label" for="science_set">Science Set</label>
                <input type="text" class="form-control" value="{{ old('science_set') ?? $request->science_set }}"
                       placeholder="Science Set"
                       name="science_set" id="science_set"/>

                <label class="form-label" for="humanities">Humanities Set (Geog, Hist, RS)</label>
                <input type="text" class="form-control" value="{{ old('humanities_set') ?? $request->humanities_set }}"
                       placeholder="Humanities Set"
                       name="humanities_set" id="humanities_set"/>

                <label class="form-label" for="classciv_set">Class Civ Set</label>
                <input type="text" class="form-control" value="{{ old('classcivset_set') ?? $request->classciv_set }}"
                       placeholder="Class Civ Set"
                       name="classciv_set" id="classciv_set"/>


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
                        <option @if($request->latin===true) selected="selected" @endif value="YES">Yes</option>
                        <option @if($request->latin===false || !isset($request->latin)) selected="selected" @endif value="NO">No</option>
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
@endsection
