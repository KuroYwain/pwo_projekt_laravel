<?php

namespace App\Services\TaskHandlers;

use Illuminate\Support\Facades\Log;

class DummyHandler implements TaskHandlerInterface
{
    public function handle(array $payload): void
    {
        Log::warning('Unhandled task type', $payload);
    }
}
