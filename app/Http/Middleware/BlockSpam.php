<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class BlockSpam
{
    /**
     * Handle an incoming request.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->input(config('honeypot.field'))) {
            return response('');
        }

        if (! $request->has(config('honeypot.valid_from_field'))) {
            return response('');
        }

        if ($this->submittedTooQuickly($request)) {
            return response('');
        }

        return $next($request);
    }

    /**
     * Check if form has been submitted too quickly.
     */
    private function submittedTooQuickly(Request $request): bool
    {
        $start = $request->input(config('honeypot.valid_from_field'));
        $diffInSeconds = (int) now()->diffInSeconds(Carbon::createFromTimestamp($start), true);

        return $diffInSeconds <= config('honeypot.seconds');
    }
}
