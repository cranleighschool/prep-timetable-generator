@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col">
            <div class="progress">
                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: 33.3%;" aria-valuenow="33.3" aria-valuemin="0" aria-valuemax="100">Step 1: Username</div>
            </div>
        </div>
    </div>
    <div class="row align-items-center justify-content-md-center">
        <div class="col-6 col-offset-3">
            <form action="{{ url('setup') }}" method="post" class="form form-inline">
                {{ csrf_field() }}
                <div class="row">
                    <div class="col">
                        <input type="text" name="username" class="form-control form-control-lg" placeholder="Username"
                               value="{{ old('username') }}"/>
                    </div>
                    <div class="col">
                        <input type="submit" class="btn btn-lg btn-secondary" value="Go">
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
