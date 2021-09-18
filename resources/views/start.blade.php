@extends('layouts.app')
@section('content')
<div class="row">
    <form method="post" class="form form-inline">
        {{ csrf_field() }}
        <div class="form-group">
        <input type="text" name="username" class="form-control form-control-lg" placeholder="Username"/>
        <input type="submit" class="btn btn-lg btn-secondary" value="Go">
        </div>
    </form>
</div>
@endsection
