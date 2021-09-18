@extends('layouts.app')
@section('content')
<p>Welcome {{ $pupilName }}, you are studying {{ $numSubjects }} subjects. Click the button below to populate your Timetable</p>
    <div>
        <form action="{{ url('generate/'.$yearGroup) }}">
            @foreach ($sets as $id => $set)
            <input type="hidden" name="sets[{{ $id }}]" value="{{ $set }}" />
            @endforeach
            <input type="submit" class="btn btn-secondary btn-lg" value="Next Step">
        </form>

    </div>
@endsection
