@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col">
            <div class="progress" style="height:30px;">
                <div class="progress-bar progress-bar-striped bg-primary" role="progressbar" style="width: 33.3%;"
                     aria-valuenow="33.3" aria-valuemin="0" aria-valuemax="100">Step 1: Your Username
                </div>
                <div class="progress-bar progress-bar-striped bg-secondary" role="progressbar" style="width: 33.3%;"
                     aria-valuenow="33.3" aria-valuemin="0" aria-valuemax="100">Step 2: Input Data
                </div>
                <div class="progress-bar progress-bar-striped bg-secondary" role="progressbar" style="width: 33.3%;"
                     aria-valuenow="33.3" aria-valuemin="0" aria-valuemax="100">Step 3: Your Prep Timetable
                </div>
            </div>
        </div>
    </div>
    <div class="row p-3">
        <div class="col">
            <label for="username" class="display-6">Your School Username</label>

            <form action="{{ url('setup') }}" method="get" class="form form-inline">
                <div class="row">
                    <div class="col">
                        <input type="text" name="username" class="form-control form-control-lg" placeholder="Enter your school username (eg: smitjo2021)"
                               value="{{ old('username') }}"/>
                        <p class="text-warning"><strong>Please note: </strong>This is only for lower school pupils in IV Form, LV and UV</p>
                    </div>
                    <div class="col">
                        <input type="submit" class="btn btn-lg btn-secondary" value="Go">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
