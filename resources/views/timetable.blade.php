@extends('layouts.app')
@section('content')
    <div class="row p-3 d-print-none">
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

    <div class="d-block d-sm-block d-md-none d-lg-none">
        <div class="row">
            <div class="col">
                <div class="alert alert-warning">The table below might look a bit strange - that's because you're viewing this on quite a small screen. Try your iPad in landscape mode?</div>
            </div>
        </div>
    </div>
    <div class="row p-3">
        <div class="col">
            <div class="card" id="timetable-card">
                <div class="card-body">
                    <h2 class="card-title">Your Prep Timetable (<code>{{ $request->username }}</code>)</h2>
                    <div class="w-auto">
                        <table class="table">
                            <thead>
                            @foreach ($timetable as $day => $values)
                                <th style="width: 20%">{{ $day }}</th>
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
                    <div class="card-footer">
                        <p class="float-end">Prep Timetable for <code>{{ $request->username }}</code> generated at <span
                                class="badge bg-secondary">{{ now()->format('Y-m-d H:i:s') }}</span>
                            using {{ url('/') }}</p>
                        <div class="clearfix">&nbsp;</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row p-3 d-print-none">
        <div style="display: none;" id="hidden-photo"></div>
        <div class="col">
            {{--            <button type="button" class="btn btn-lg btn-success" id="copy-to-clipboard"--}}
            {{--                    onclick="CopyToClipboard('timetable-card')"><svg xmlns="http://www.w3.org/2000/svg" style="width:24px;" fill="none" viewBox="0 0 24 24" stroke="currentColor">--}}
            {{--                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />--}}
            {{--                </svg>Copy Table Contents to Clipboard--}}
            {{--            </button>--}}
            <a class="btn btn-lg btn-success" id="download" download="{{ $request->username }}.png">
                <svg xmlns="http://www.w3.org/2000/svg" class="" style="width:24px" fill="none" viewBox="0 0 24 24"
                     stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download as Image</a>
        </div>
    </div>
    <div class="row p-3">
        <div class="col">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <h2>Your {{ $requestSets->count() }} Subjects & Set Codes</h2>
                        @foreach ($requestSets->sort()->chunk(ceil($requestSets->count() / 4)) as $chunks)
                            <div class="col-sm-3">
                                @foreach ($chunks as $code => $subject)
                                    <div class="col">{{ $subject }}
                                        (<code>{{ $code }}</code>) {!! \App\Models\SubjectsSet::label($code) !!}
                                    </div>
                                @endforeach
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        function CopyToClipboard(containerid) {
            if (document.selection) {
                var range = document.body.createTextRange();
                range.moveToElementText(document.getElementById(containerid));
                range.select().createTextRange();
                document.execCommand("copy");
            } else if (window.getSelection) {
                var range = document.createRange();
                range.selectNode(document.getElementById(containerid));
                window.getSelection().addRange(range);
                document.execCommand("copy");
                alert("Text has been copied, now paste in the text-area")
            }
        }
    </script>

@endpush
