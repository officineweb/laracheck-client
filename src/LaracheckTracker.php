<?php

namespace Laracheck\Client;

use Illuminate\Support\Facades\Http;

class LaracheckTracker
{
    public function track($exceptions): void
    {
        $exceptions->report(function (\Throwable $exception) {
            if (config('laracheck.api_key') && config('laracheck.endpoint')) {
                $this->sendTrack($exception);
            }
        });
    }

    private function sendTrack($exception): void
    {
        try {
            // Get the HTTP status code from the exception if available
            $code = $this->getStatusCode($exception);

            Http::withHeaders([
                'Authorization' => config('laracheck.api_key'),
                'Accept' => 'application/json',
                'Content-Type' => 'application/json',
            ])
                ->timeout(5)
                ->post(config('laracheck.endpoint'), [
                    'exception' => $exception->getMessage(),
                    'line' => $exception->getLine(),
                    'file' => $exception->getFile(),
                    'class' => get_class($exception),
                    'host' => request()->getHost(),
                    'env' => app()->environment(),
                    'method' => request()->method(),
                    'code' => $code,
                    'fullUrl' => request()->fullUrl(),
                    'error' => $exception->getMessage(),
                    'user' => auth()->check() ? [
                        'id' => auth()->id(),
                        'email' => auth()->user()->email ?? null,
                        'name' => auth()->user()->name ?? null,
                    ] : null,
                    'storage' => [
                        'server' => request()->server->all(),
                    ],
                    'executor' => [
                        'trace' => collect($exception->getTrace())->take(10)->toArray(),
                    ],
                    'additional' => [
                        'ip' => request()->ip(),
                        'user_agent' => request()->header('User-Agent'),
                    ],
                ]);
        } catch (\Throwable $th) {
            // Silently fail to avoid infinite loops
        }
    }

    private function getStatusCode(\Throwable $exception): int
    {
        // Check if the exception has a status code method (like HttpException)
        if (method_exists($exception, 'getStatusCode')) {
            return $exception->getStatusCode();
        }

        // Check if the exception code is a valid HTTP status code
        $code = $exception->getCode();
        if ($code >= 100 && $code < 600) {
            return $code;
        }

        // Default to 500 for all other exceptions
        return 500;
    }
}
