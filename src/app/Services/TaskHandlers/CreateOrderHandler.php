<?php

// App\Services\TaskHandlers\CreateOrderHandler.php

namespace App\Services\TaskHandlers;

use Illuminate\Support\Facades\Log;
use App\Models\Order;

class CreateOrderHandler
{
    public function handle(array $payload): void
    {
        Order::create([
            'user_id' => $payload['user_id'],
            'product_id' => $payload['product_id'],
            'quantity' => $payload['quantity'],
            'status' => 'pending',
        ]);

        Log::info("✅ Order created via client queue", ['payload' => $payload]);
    }
}

