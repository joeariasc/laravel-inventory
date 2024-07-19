<?php

namespace App\Breadcrumbs;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class Breadcrumbs
{
    protected $request;

    public function __construct(Request $request)
    {
        return $this->request = $request;
    }

    public function segments(): array
    {
        Log::info("segments: " . json_encode($this->request->segments()));
        return collect($this->request->segments())->map(function ($segment) {
            return new Segment($this->request, $segment);
        })->toArray();
    }
}
