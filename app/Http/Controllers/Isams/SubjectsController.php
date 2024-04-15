<?php

namespace App\Http\Controllers\Isams;

use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use spkm\isams\Endpoint;
use stdClass;

class SubjectsController extends Endpoint
{
    /**
     * @throws GuzzleException
     *
     * @return Collection<array-key, mixed>
     */
    public function index(): Collection
    {
        $key = $this->institution->getConfigName().'subjects.index';

        $decoded = json_decode($this->pageRequest($this->endpoint, 1));

        // @phpstan-ignore-next-line
        $items = collect($decoded->sets);

        return Cache::remember($key, config('isams.cacheDuration'), function () use ($items) {
            return $items;
        });
    }

    /**
     * @throws GuzzleException
     *
     * @return Collection<array-key, stdClass>
     */
    public function show(int $subjectId): Collection
    {
        $decode = json_decode($this->pageRequest($this->endpoint.'/'.$subjectId, 1));
        // @phpstan-ignore-next-line
        $items = collect($decode);

        return $items;
    }

    protected function setEndpoint(): void
    {
        $this->endpoint = $this->getDomain().'/api/teaching/subjects';
    }
}
