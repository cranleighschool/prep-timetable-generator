@extends('layouts.app')
@section('content')
    <form action="{{ url('generate/'.$yearGroup) }}" class="form-inline" method="POST">
        {{ csrf_field() }}
        {{ method_field('POST') }}
        <input type="hidden" name="yearGroup" value="{{ $yearGroup }}"/>
        <div class="row">
            <div class="col"><h2>Your {{ $sets->count() }} Subjects</h2>
                <ul class="two-columns">
                    @foreach ($sets->sort() as $code => $subject)
                        <li>{{ $subject }} (<code>{{ $code }}</code>) {!! \App\Models\ScienceSet::label($code) !!}</li>
                    @endforeach
                </ul>
            </div>
        </div>
        <h2>Fill in the details below</h2>
        <div class="row">
            <div class="col">
                <label class="form-label" for="science_set">Science Set</label>
                <input type="number" class="form-control" value="{{ old('science_set') ?? $request->science_set }}"
                       placeholder="Science Set"
                       name="science_set" id="science_set"/>
                @if ($yearGroup===9)
                    <label class="form-label" for="humanities">Humanities Set (Geog, Hist, RS)</label>
                    <input type="number" class="form-control"
                           value="{{ old('humanities_set') ?? $request->humanities_set }}"
                           placeholder="Humanities Set"
                           name="humanities_set" id="humanities_set"/>

                    @if (!in_array('Latin', $sets->toArray()))
                        <label class="form-label" for="classciv_set">Class Civ Set</label>
                        <input type="number" class="form-control"
                               value="{{ old('classcivset_set') ?? $request->classciv_set }}"
                               placeholder="Class Civ Set"
                               name="classciv_set" id="classciv_set"/>
                    @endif
                    <label class="form-label" for="maths_set">Maths Set</label>
                    <input class="form-control" type="text" value="{{ old('maths_set') ?? $request->maths_set }}"
                           placeholder="Maths Set"
                           name="maths_set" id="maths_set"/>
                @endif
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
                @if ($yearGroup !== 9)
                    <label class="form-label" for="optionc">Option D</label>
                    <input class="form-control" type="text" value="{{ old('optiond') ?? $request->optiond }}"
                           placeholder="Option D"
                           name="optiond"/>
                @endif
            </div>
            <div class="col">
                <label class="form-label" for="cmlf">CMFL</label>
                <input class="form-control" type="text" value="{{ old('cmfl') ?? $request->cmfl }}" placeholder="CMFL"
                       name="cmfl"/>

                @if ($yearGroup == 9)
                    <label class="form-label" for="latin">
                        <span class="">Do you do Latin?</span>
                        <select class="form-select mt-1 block w-full" placeholder="Thingy" name="latin">
                            <option @if(in_array('Latin', $sets->toArray())) selected="selected" @endif value="YES">Yes
                            </option>
                            <option @if(!in_array('Latin', $sets->toArray())) selected="selected" @endif value="NO">No
                            </option>
                        </select>
                    </label>
                @endif
            </div>
        </div>
        <div class="row">
            <div class="col">
                <input class="btn-lg btn btn-block btn-primary" value="Generate Timetable" type="submit">
            </div>
        </div>
    </form>
    </div>
@endsection