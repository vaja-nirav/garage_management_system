<?php

namespace App\Services;

use SimpleStatsIo\LaravelClient\SimplestatsClient;
use Illuminate\Support\Collection;

class CustomSimplestatsClient extends SimplestatsClient
{
    /**
     * Override getSessionTracking to coerce array/collection values.
     */
    protected function getSessionTracking(): Collection
    {
        $tracking = session('simplestats.tracking');

        if ($tracking instanceof Collection) {
            return $tracking;
        }

        if (is_array($tracking)) {
            return collect($tracking);
        }

        return collect();
    }
}
