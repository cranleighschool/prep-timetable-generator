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
                    <p class="card-text"> You have {{ count($request->sets) }} subjects. Below
                        you'll see which set you are in for each subject. Correct anything you feel you need to in the
                        form,
                        then you can generate your prep timetable!</p>
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
                                        (<code>{{ $code }}</code>) {!! \App\Models\SubjectsSet::label($code) !!}
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
                        <input type="hidden" name="username" value="{{ $request->username }}"/>

                        <div class="row p-3">
                            <div class="row">
                                <div class="col">
                                    <h2>Double check the details below</h2>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md">
                                    @if ($yearGroup===9)
                                        <label class="form-label" for="science_set">Science Set</label>
                                        <input required="required" type="number" class="form-control"
                                               value="{{ old('science_set') ?? $setResults['Science'] }}"
                                               placeholder="Science Set"
                                               name="science_set" id="science_set"/>
                                    @else
                                        @foreach (['Biology', 'Chemistry', 'Physics'] as $scienceSubject)
                                            <label class="form-label"
                                                   for="{{ strtolower($scienceSubject) }}_set">{{ $scienceSubject }}
                                                Set</label>
                                            <input required="required" type="text" class="form-control"
                                                   value="{{ old(strtolower($scienceSubject).'_set') ?? $setResults[$scienceSubject] }}"
                                                   placeholder="{{ $scienceSubject }} Set"
                                                   name="{{ strtolower($scienceSubject) }}_set"
                                                   id="{{ strtolower($scienceSubject) }}_set"/>
                                        @endforeach
                                    @endif
                                    @if ($yearGroup===9)
                                        <label class="form-label" for="english_set">English Set</label>
                                        <input required="required" type="text" class="form-control"
                                               value="{{ old('english_set') ?? $setResults['English'] }}"
                                               placeholder="English Set"
                                               name="english_set" id="english_set"/>

                                        <label class="form-label" for="humanities">Humanities Set (Geog, Hist,
                                            RS)</label>
                                        <input required="required" type="text" class="form-control"
                                               value="{{ old('humanities_set') ?? $setResults['Humanities'] }}"
                                               placeholder="Humanities Set"
                                               name="humanities_set" id="humanities_set"/>

                                        @if (!in_array('Latin', $sets->toArray()))
                                            <label class="form-label" for="classciv_set">Class Civ Set</label>
                                            <input required="required" type="text" class="form-control"
                                                   value="{{ old('classciv_set') ?? $setResults['Classical Civilisation'] }}"
                                                   placeholder="Class Civ Set"
                                                   name="classciv_set" id="classciv_set"/>
                                        @endif
                                        <label class="form-label" for="maths_set">Maths Set</label>
                                        <input required="required" class="form-control" type="text"
                                               value="{{ old('maths_set') ?? $setResults['Maths'] }}"
                                               placeholder="Maths Set"
                                               name="maths_set" id="maths_set"/>
                                    @endif
                                </div>
                                <div class="col-md">
                                    <label class="form-label" for="optiona">Option A</label>
                                    <input class="form-control" type="text"
                                           value="{{ old('optiona') ?? $setResults['Option A'] }}"
                                           placeholder="Option A" name="optiona"/>

                                    @if (isset($setResults['Option B']))
                                        <label class="form-label" for="optionb">Option B</label>
                                        <input class="form-control" type="text"
                                               value="{{ old('optionb') ?? $setResults['Option B'] }}"
                                               placeholder="Option B"
                                               name="optionb"/>
                                    @endif

                                    @if (isset($setResults['Option C']))
                                        <label class="form-label" for="optionc">Option C</label>
                                        <input class="form-control" type="text"
                                               value="{{ old('optionc') ?? $setResults['Option C'] }}"
                                               placeholder="Option C"
                                               name="optionc"/>
                                    @endif

                                    <label class="form-label" for="optiond">Option D</label>
                                    <input class="form-control" type="text"
                                           value="{{ old('optiond') ?? ($setResults['Option D'] ?? '') }}"
                                           placeholder="Option D"
                                           name="optiond"/>

                                    @if (isset($setResults['Option E']))
                                        <label class="form-label" for="optione">Option E</label>
                                        <input class="form-control" type="text"
                                               value="{{ old('optione') ?? ($setResults['Option E'] ?? '') }}"
                                               placeholder="Option E"
                                               name="optione"/>
                                    @endif

                                </div>
                                @if ($yearGroup !== 10)
                                    <div class="col-md">
                                        <label class="form-label" for="cmlf">Modern Foreign Language</label>
                                        <input class="form-control" type="text"
                                               value="{{ old('cmfl') ?? $setResults['CMFL'] ?? null}}"
                                               placeholder="CMFL"
                                               name="cmfl"/>
                                        @endif
                                        @if ($yearGroup == 9)
                                            <label class="form-label" for="latin">
                                                <span class="">Do you do Latin?</span>
                                                <select class="form-select mt-1 block w-full" placeholder="Thingy"
                                                        name="latin">
                                                    <option @if(in_array('Latin', $sets->toArray())) selected="selected"
                                                            @endif value="YES">
                                                        Yes
                                                    </option>
                                                    <option
                                                        @if(!in_array('Latin', $sets->toArray())) selected="selected"
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
