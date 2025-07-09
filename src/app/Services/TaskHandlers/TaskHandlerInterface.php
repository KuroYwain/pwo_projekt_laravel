<?php

namespace App\Services\TaskHandlers;

interface TaskHandlerInterface {
    public function handle(array $payload): void;
}
