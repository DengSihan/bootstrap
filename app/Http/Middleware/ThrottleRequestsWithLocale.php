<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Middleware\ThrottleRequests;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Exceptions\ThrottleRequestsException;

class ThrottleRequestsWithLocale extends ThrottleRequests
{
    /**
     * Create a 'too many attempts' exception.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $key
     * @param  int  $maxAttempts
     * @param  callable|null  $responseCallback
     * @return \Illuminate\Http\Exceptions\ThrottleRequestsException
     */
    protected function buildException($request, $key, $maxAttempts, $responseCallback = null)
    {
        $retryAfter = $this->getTimeUntilNextRetry($key);

        $headers = $this->getHeaders(
            $maxAttempts,
            $this->calculateRemainingAttempts($key, $maxAttempts, $retryAfter),
            $retryAfter
        );

        return is_callable($responseCallback)
                    ? new HttpResponseException($responseCallback($request, $headers))
                    : new ThrottleRequestsException(__('throttle.too_many_attempts'), null, $headers);
    }
}
