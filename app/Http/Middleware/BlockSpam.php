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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
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
     *
     * @param  Request  $request
     * @return bool
     */
    private function submittedTooQuickly(Request $request): bool
    {
        $start = $request->input(config('honeypot.valid_from_field'));

        return now()->diffInSeconds(Carbon::createFromTimestamp($start)) <= config('honeypot.seconds');
    }
}
