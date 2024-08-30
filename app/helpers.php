<?php
if (! function_exists('defaultIsamsInstitution')) {
    function defaultIsamsInstitution(): \App\Models\School
    {
        return \Illuminate\Support\Facades\Cache::rememberForever('defaultIsamsInstitution', function () {
            return \App\Models\School::query()->findOrFail(1);
        });
    }
}
