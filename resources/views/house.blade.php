@extends('layouts.app')
@section('content')
    @if (isset($data['errors']))
        @foreach ($data['errors'] as $error)
            <div class="alert alert-danger">{{ $error }}</div>
        @endforeach
    @endif
    @foreach($data as $yearGroup => $pupils)
        @if (is_string($yearGroup))
            @continue
            @endif
        <h2>Year {{ $yearGroup }} Pupils</h2>
        <table class="table table-striped table-bordered">
            <thead>
            <th style="width: 17%">Pupil</th>
            @foreach (\App\Models\PrepDay::all() as $day)
                <th style="width:16.6%">{{ $day->day }}</th>
            @endforeach
            </thead>
            <tbody>

            @foreach($pupils as $pupil => $days)
                <tr>
                    <th>{{ $pupil }}</th>
                    @foreach ($days as $day)
                        <td>{!! implode('<br />', $day) !!}</td>
                    @endforeach
                </tr>
            @endforeach
            </tbody>
        </table>
    @endforeach
@endsection
