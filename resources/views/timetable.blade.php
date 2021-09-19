@extends('layouts.app')
@section('content')
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

    <hr />
        <a href="javascript:history.back()" class="btn btn-lg btn-primary">Go Back</a>
        <a href="{{ url('/') }}" class="btn btn-lg btn-secondary">Start Over</a>
@endsection
