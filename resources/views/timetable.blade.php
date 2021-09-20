@extends('layouts.app')
@section('content')
    <div class="row">
        <div class="col">
            <div class="progress" style="height:30px;">
                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 33.3%;"
                     aria-valuenow="33.3" aria-valuemin="0" aria-valuemax="100">Step 1: Your Username
                </div>
                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 33.3%;"
                     aria-valuenow="33.3" aria-valuemin="0" aria-valuemax="100">Step 2: Input Data
                </div>
                <div class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 33.3%;"
                     aria-valuenow="33.3" aria-valuemin="0" aria-valuemax="100">Step 3: Your Prep Timetable
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row p-3">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <h2 class="card-title">Your Timetable</h2>
                        <div class="table-responsive">
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
                        </div>
                    </div>
                </div>
            </div>
        </div>

@endsection
