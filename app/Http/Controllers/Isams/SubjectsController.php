<?php

namespace App\Http\Controllers\Isams;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use spkm\isams\Endpoint;

class SubjectsController extends Endpoint
{
    public function index(): Collection
    {
        $key = $this->institution->getConfigName().'subjects.index';

        $decoded = json_decode($this->pageRequest($this->endpoint, 1));
        $items = collect($decoded->sets);

        return Cache::remember($key, config('isams.cacheDuration'), function () use ($items) {
            return $items;
        });
    }

    public function show($subjectId)
    {
        $decode = json_decode($this->pageRequest($this->endpoint.'/'.$subjectId, 1));
        $items = collect($decode);

        return $items;
    }

    protected function setEndpoint(): void
    {
        $this->endpoint = $this->getDomain().'/api/teaching/subjects';
    }
}
