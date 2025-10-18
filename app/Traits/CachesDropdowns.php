<?php

namespace App\Traits;
use Illuminate\Support\Facades\Cache;

trait CachesDropdowns
{
      public function cacheDropdown($key, $minutes, $callback)
    {
        return Cache::remember($key, now()->addMinutes($minutes), $callback);
    }

    public function clearDropdownCache(array $keys)
    {
        foreach ($keys as $key) {
            Cache::forget($key);
        }
    }
}

    

