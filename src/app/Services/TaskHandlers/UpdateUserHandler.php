<?php

namespace App\Services\TaskHandlers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateUserHandler implements TaskHandlerInterface
{
    public function handle(array $payload): void
    {
        $userId = $payload['user_id'] ?? null;
        $email = $payload['email'] ?? null;

        if ($userId && $email) {
            DB::table('users')->where('id', $userId)->update(['email' => $email]);
            Log::info("User {$userId} updated to {$email}");
        } else {
            Log::warning("Invalid update_user payload", $payload);
        }
    }
}
