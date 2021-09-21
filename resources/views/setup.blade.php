@extends('layouts.app')
@section('content')
    <div class="row p-3">
        <div class="col">
            <div class="progress" style="height:30px;">
                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 33.3%;"
                     aria-valuenow="33.3" aria-valuemin="0" aria-valuemax="100">Step 1: Your Username
                </div>
                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 33.3%;"
                     aria-valuenow="33.3" aria-valuemin="0" aria-valuemax="100">Step 2: Input Data
                </div>
                <div class="progress-bar progress-bar-striped bg-secondary" role="progressbar" style="width: 33.3%;"
                     aria-valuenow="33.3" aria-valuemin="0" aria-valuemax="100">Step 3: Prep Timetable
                </div>
            </div>
        </div>
    </div>
    <div class="row p-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Welcome {{ $request->pupil->preferredName }}!</h5>
                    <p class="card-text"> You have {{ count($request->sets) }} subjects. Below in the green labels
                        you'll see which set you are in for each subject. Use this information to fill in the form
                        below, then you can generate your prep timetable!</p>
                </div>
            </div>
        </div>
    </div>
    <div class="row p-3">
        <aside class="col-md-4 mb-4">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-body">
                            <h2>Your {{ $sets->count() }} Subjects</h2>
                            <ul class="">
                                @foreach ($sets->sort() as $code => $subject)
                                    <li>{{ $subject }}
                                        (<code>{{ $code }}</code>) {!! \App\Models\ScienceSet::label($code) !!}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
        <div class="col-md">
            <div class="card">
                <div class="card-body">
                    <form action="{{ url('generate/'.$yearGroup) }}" class="form-inline" method="POST">
                        {{ csrf_field() }}
                        {{ method_field('POST') }}
                        <input type="hidden" name="yearGroup" value="{{ $yearGroup }}"/>
                        <input type="hidden" name="username" value="{{ $request->username }}" />

                        <div class="row p-3">
                            <div class="row">
                                <div class="col">
                                    <h2>Fill in the details below</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    @if ($yearGroup===9)
                                        <label class="form-label" for="science_set">Science Set</label>
                                        <input required="required" type="number" class="form-control"
                                               value="{{ old('science_set') ?? $request->science_set }}"
                                               placeholder="Science Set"
                                               name="science_set" id="science_set"/>
                                    @else
                                        @foreach (['Biology', 'Chemistry', 'Physics'] as $scienceSubject)
                                            <label class="form-label"
                                                   for="{{ strtolower($scienceSubject) }}_set">{{ $scienceSubject }}
                                                Set</label>
                                            <input required="required" type="number" class="form-control"
                                                   value="{{ old(strtolower($scienceSubject).'_set') ?? $request->{$scienceSubject.'_set'} }}"
                                                   placeholder="{{ $scienceSubject }} Set"
                                                   name="{{ strtolower($scienceSubject) }}_set"
                                                   id="{{ strtolower($scienceSubject) }}_set"/>
                                        @endforeach
                                    @endif
                                    @if ($yearGroup===9)
                                        <label class="form-label" for="humanities">Humanities Set (Geog, Hist,
                                            RS)</label>
                                        <input required="required" type="number" class="form-control"
                                               value="{{ old('humanities_set') ?? $request->humanities_set }}"
                                               placeholder="Humanities Set"
                                               name="humanities_set" id="humanities_set"/>

                                        @if (!in_array('Latin', $sets->toArray()))
                                            <label class="form-label" for="classciv_set">Class Civ Set</label>
                                            <input required="required" type="number" class="form-control"
                                                   value="{{ old('classciv_set') ?? $request->classciv_set }}"
                                                   placeholder="Class Civ Set"
                                                   name="classciv_set" id="classciv_set"/>
                                        @endif
                                        <label class="form-label" for="maths_set">Maths Set</label>
                                        <input required="required" class="form-control" type="text"
                                               value="{{ old('maths_set') ?? $request->maths_set }}"
                                               placeholder="Maths Set"
                                               name="maths_set" id="maths_set"/>
                                    @endif
                                </div>
                                <div class="col-md">
                                    <label class="form-label" for="optiona">Option A</label>
                                    <input class="form-control" type="text"
                                           value="{{ old('optiona') ?? $request->optiona }}"
                                           placeholder="Option A" name="optiona"/>

                                    <label class="form-label" for="optionb">Option B</label>
                                    <input class="form-control" type="text"
                                           value="{{ old('optionb') ?? $request->optionb }}"
                                           placeholder="Option B"
                                           name="optionb"/>

                                    <label class="form-label" for="optionc">Option C</label>
                                    <input class="form-control" type="text"
                                           value="{{ old('optionc') ?? $request->optionc }}"
                                           placeholder="Option C"
                                           name="optionc"/>
                                    @if ($yearGroup !== 9)
                                        <label class="form-label" for="optionc">Option D</label>
                                        <input class="form-control" type="text"
                                               value="{{ old('optiond') ?? $request->optiond }}"
                                               placeholder="Option D"
                                               name="optiond"/>
                                    @endif
                                </div>
                                <div class="col-md">
                                    <label class="form-label" for="cmlf">Modern Foreign Language</label>
                                    <input class="form-control" type="text" value="{{ old('cmfl') ?? $request->cmfl }}"
                                           placeholder="CMFL"
                                           name="cmfl"/>

                                    @if ($yearGroup == 9)
                                        <label class="form-label" for="latin">
                                            <span class="">Do you do Latin?</span>
                                            <select class="form-select mt-1 block w-full" placeholder="Thingy"
                                                    name="latin">
                                                <option @if(in_array('Latin', $sets->toArray())) selected="selected"
                                                        @endif value="YES">
                                                    Yes
                                                </option>
                                                <option @if(!in_array('Latin', $sets->toArray())) selected="selected"
                                                        @endif value="NO">
                                                    No
                                                </option>
                                            </select>
                                        </label>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="row p-3">
                            <div class="col">
                                <input class=" text-center btn-lg btn btn-block btn-primary" value="Generate Timetable"
                                       type="submit">
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection
